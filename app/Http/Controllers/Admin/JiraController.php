<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Jira;
use App\TipoResponsable;
use App\Http\Controllers\Controller;
use App\TipoJira;
use App\JiraAccion;
use App\TipoAccionJira;
use App\TipoPrioridad;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Requests\StoreJiraRequest;
use App\Http\Requests\UpdateJiraRequest;
use Illuminate\Support\Facades\DB;
use App\Incidente;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Http\Controllers\Admin\EnvioCorreoController;
use App\TipoJiraUser;

class JiraController extends Controller
{
    function __construct()
    {
        $this->middleware('can:create jira', ['only' => ['create', 'store']]);
        $this->middleware('can:edit jira', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete jira', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $JirasAcciones =  DB::table('jiras')
                    ->join('jiras_acciones', 'jiras.jira_id', '=', 'jiras_acciones.jira_id')
                    ->select(DB::raw('max(jiras_acciones.jiac_id) as jiac_id'))
                    ->groupBy('jiras.jira_id');
        if(!$user->hasRole('admin')){
            $TiposJiras = TipoJiraUser::join('users', 'users.id', '=', 'tipo_jiras_users.user_id')
                                ->where('users.id', $user->id)
                                ->select('tiji_id')
                                ->get()
                                ->toArray();
//            print_f($TiposJiras->toSql());
            $JirasAcciones = $JirasAcciones->wherein('jiras.tiji_id', $TiposJiras);                        
        }    
  //      print_f($JirasAcciones->toSql());
        $JirasAcciones = $JirasAcciones->get();

        $JirasAcciones = json_decode($JirasAcciones);
        //$jiac_ids = '';
        foreach ($JirasAcciones as $JiraAccion){
            $jiac_ids[] = $JiraAccion->jiac_id.',';
        }
        //$jiac_ids = substr($jiac_ids, 0, -1);
        //print_f($jiac_ids);
        $jiras = Jira::select('jiras.jira_id', 'jiras_acciones.jiac_id', 'jiras.jira_codigo', 
                    'jiras.jira_asunto', 'jiras.jira_fecha', 
                    'tipo_estados.ties_nombre', 'tipo_acciones_jiras.tiaj_responsable_siguiente', 
                    'versiones.vers_nombre', 'jiras_acciones.jiac_fecha')
            ->join('jiras_acciones', 'jiras_acciones.jira_id', '=', 'jiras.jira_id')
            ->join('tipo_acciones_jiras', 'tipo_acciones_jiras.tiaj_id', '=', 'jiras_acciones.tiaj_id')
            ->join('tipo_estados','jiras.ties_id', '=', 'tipo_estados.ties_id')
            ->join('versiones','jiras.vers_id', '=', 'versiones.vers_id');
            if (isset($jiac_ids)){
                $jiras = $jiras->wherein('jiras_acciones.jiac_id', $jiac_ids);
            }
        //    ->toSql();
        $jiras = $jiras->get();
        //print_f($jiras);
        return view('admin.jira.index', compact('jiras'));
    }

    public function create()
    {
        $user = User::findOrFail(Auth::id());

        $tipo_responsables = TipoResponsable::where('tire_activo', true)
                            ->where('tire_area', 'Interno')
                            ->select('tire_id', 'tire_nombre')
                            ->pluck('tire_nombre', 'tire_id')
                            ->prepend('Seleccionar', '')
                            ->sortByDesc('tire_indice')
                            ->toArray();
        $tipo_prioridades = TipoPrioridad::where('tipr_activo', true)
                            ->select('tipr_id', 'tipr_nombre')
                            ->pluck('tipr_nombre', 'tipr_id')
                            ->prepend('Seleccionar', '')
                            ->sortByDesc('tipr_indice')
                            ->toArray();               
        $tipo_jiras = TipoJira::where('tiji_activo', true);
        if(!$user->hasRole('admin')){
            $TiposJiras = TipoJiraUser::join('users', 'users.id', '=', 'tipo_jiras_users.user_id')
                                ->where('users.id', $user->id)
                                ->select('tiji_id')
                                ->get()
                                ->toArray();              
            $tipo_jiras = $tipo_jiras->wherein('tipo_jiras.tiji_id', $TiposJiras);
        }
        $tipo_jiras = $tipo_jiras->select(DB::raw('tiji_id, CONCAT(tiji_sistema, "-", tiji_nombre) as tiji_nombre'))
                            ->pluck('tiji_nombre', 'tiji_id')
                            ->prepend('Seleccionar', '')
                            ->sortByDesc('tiji_indice')
                            ->toArray();

        return view('admin.jira.create')
                ->with(compact('tipo_responsables'))
                ->with(compact('tipo_prioridades'))
                ->with(compact('tipo_jiras'));
    }

    public function store(StoreJiraRequest $request)
    {
        $user = User::findOrFail(Auth::id());
        $jira = new Jira();
        $jira->tire_id = $request->tire_id;
        $jira->ties_id = 1; 
        $jira->tipr_id = $request->tipr_id;
        $jira->tiji_id = $request->tiji_id;
        $jira->vers_id = 1;
        $jira->user_id = $user->id;
        $jira->jira_codigo = $request->jira_codigo;
        $jira->jira_asunto = $request->jira_asunto;
        $jira->jira_descripcion = $request->jira_descripcion;
        $jira->jira_fecha = Carbon::parse($request->jira_fecha);
        $jira->jira_activo = true;
        $jira->save();

        $TipoJira = TipoJira::FindOrFail($request->tiji_id);

        $incidentes = new Incidente();
        $IncidentesShow = $incidentes->ObtenerIncidentes($jira);

        $jiraAccion = new JiraAccion();
        $jiraAccion->jira_id = $jira->jira_id;
        $jiraAccion->tiaj_id = TipoAccionJira::tiaj_codigo_id('CREACION_JIRA');
        $jiraAccion->jiac_descripcion = ':: Creación de Jira por el usuarios '.$user->name.' ::';
        $jiraAccion->jiac_fecha = Carbon::parse($request->jira_fecha);
        $jiraAccion->user_id = $user->id;
        $jiraAccion->jiac_activo = true;
        $jiraAccion->save();

        $JiraUpdate = Jira::findOrFail($jira->jira_id);
        if ($TipoJira->tiji_servicedesk){
            if ($IncidentesShow->count() > 0) {
                $JiraUpdate->jira_reportado = true;
                $tipoMensaje = 'success';
                $Mensaje = 'El jira ha sido creado y reportado al hospital.';
            }
            else{
                $JiraUpdate->jira_reportado = false;
                $tipoMensaje = 'warning';
                $Mensaje = 'El jira ha sido creado, pero no fue reportado porque no existen ticket asociados en la mesa de ayuda.';
            }
        }
        else{
            $JiraUpdate->jira_reportado = true;
            $tipoMensaje = 'success';
            $Mensaje = 'El jira ha sido creado y reportado al hospital.';
        }
        $JiraUpdate->save();

        $EnvioCorreo = new EnvioCorreoController();
        $datos = $EnvioCorreo->EnvioCorreoJira($jira->jira_id, TipoAccionJira::tiaj_codigo_id('CREACION_JIRA'));
        return redirect('admin/jira')
                    ->with($tipoMensaje, $Mensaje); 
    }

    public function show($id)
    {
        $jira = Jira::where('jiras.jira_id', $id)
                        ->join('tipo_estados','jiras.ties_id', '=', 'tipo_estados.ties_id')
                        ->join('versiones','jiras.vers_id', '=', 'versiones.vers_id')
                        ->join('tipo_prioridades','jiras.tipr_id', '=', 'tipo_prioridades.tipr_id')
                        ->join('tipo_responsables','jiras.tire_id', '=', 'tipo_responsables.tire_id')
                        ->join('tipo_jiras','jiras.tiji_id', '=', 'tipo_jiras.tiji_id')
                        ->join('users','jiras.user_id', '=', 'users.id')
                        ->leftJoin('jiras_acciones', function($join)
                        {
                            $join->on('jiras.jira_id', '=', 'jiras_acciones.jira_id');
                            $join->where('jiras_acciones.jiac_activo', '=', true);
                        })
                        ->join('tipo_acciones_jiras','tipo_acciones_jiras.tiaj_id', '=', 'jiras_acciones.tiaj_id')
                        ->whereNotIn('tipo_acciones_jiras.tiaj_codigo', ['PRUEBAS_REGRESIVAS', 'PASO_PRODUCCION'])
                        ->select('jiras.jira_id', 'jiras.jira_codigo', 'jiras.jira_asunto', 'jiras.jira_descripcion', 
                                'tipo_responsables.tire_nombre', 'tipo_prioridades.tipr_nombre', 
                                'versiones.vers_nombre', 'tipo_estados.ties_nombre', 
                                'tipo_jiras.tiji_nombre', 'jiras.jira_fecha', 'users.name as user_nombre',
                                'tipo_acciones_jiras.tiaj_responsable_siguiente', 'tipo_acciones_jiras.tiaj_responsable_actual',
                                'jiras.jira_reportado')
                        ->orderBy('jiras_acciones.jiac_id', 'DESC')
                        ->get()->first();

        $user = User::findOrFail(Auth::id());        

        $jiraacciones = JiraAccion::where('jiras_acciones.jira_id', $id)
                        ->join('tipo_acciones_jiras', 'jiras_acciones.tiaj_id', '=',  'tipo_acciones_jiras.tiaj_id')
                        ->join('users', 'jiras_acciones.user_id', '=',  'users.id')
                        ->select('jiras_acciones.jiac_id', 'tipo_acciones_jiras.tiaj_nombre', 
                            'tipo_acciones_jiras.tiaj_indice', 'jiras_acciones.jiac_fecha', 
                            'users.name as user_nombre', 'jiras_acciones.jiac_ruta',
                            'tipo_acciones_jiras.tiaj_responsable_actual', 'jiras_acciones.jiac_descripcion')
                        ->orderBy('jiras_acciones.jira_id', 'ASC')
                        ->get();

        $JiraAccion = TipoAccionJira::select('tipo_acciones_jiras.tiaj_sucesor')
                        ->join('jiras_acciones', 'tipo_acciones_jiras.tiaj_id', '=', 'jiras_acciones.tiaj_id') 
                        ->where('jiras_acciones.jira_id', $id)  
                        ->whereNotIn('tipo_acciones_jiras.tiaj_codigo', ['PRUEBAS_REGRESIVAS', 'PASO_PRODUCCION'])
                        ->orderBy('jiras_acciones.jiac_id', 'DESC')
                        //->toSql();
                        //print_f(JiraAccion);
                        ->first();
        $tiaj_sucesor = explode('|', $JiraAccion->tiaj_sucesor);

        $tipo_accion_jira = TipoAccionJira::where('tiaj_activo', true)
            ->select('tiaj_id', 'tiaj_nombre')
            ->where('tiaj_responsable_actual', $user->area)
            ->whereIn('tiaj_indice', $tiaj_sucesor)

            ->where('tiaj_tipo', 'Jira')
            ->orderBy('tiaj_indice', 'ASC');
            //->toSql();
        //print_f($tipo_accion_jira);    
            
        $cantidad = $tipo_accion_jira->count();  

        if ($cantidad == 0){
            $crear = false;
            if ($user->area == 'Interno'){
                $warning = 'El Jira requiere atención de HLF';
            }
            if ($user->area == 'Externo'){
                $warning = 'El Jira requiere atención de Indra';
            }
            session(['warning' => $warning]);
            return view('admin.jira.show')
            ->with(compact('jira'))
            ->with(compact('jiraacciones'))
            ->with(compact('user'))
            ->with(compact('crear'));

        }
        else{
            if ($jira->jira_reportado){
                $crear = true;
                return view('admin.jira.show')
                ->with(compact('jira'))
                ->with(compact('jiraacciones'))
                ->with(compact('user'))
                ->with(compact('crear'));
            }
            else{
                $incidentes = new Incidente();
                $IncidentesShow = $incidentes->ObtenerIncidentes($jira);
        
                $JiraUpdate = Jira::findOrFail($jira->jira_id);
                if ($IncidentesShow->count() > 0) {
                    $JiraUpdate->jira_reportado = true;
                    $crear = true;
                    $tipoMensaje = 'success';
                    $Mensaje = 'El jira ha sido reportado al hospital.';
                }
                else{
                    $JiraUpdate->jira_reportado = false;
                    $tipoMensaje = 'warning';
                    $crear = false;
                    $Mensaje = 'El jira no ha sido reportado porque no existen ticket asociados en la mesa de ayuda.';
                }
                $JiraUpdate->save();
        
                session([$tipoMensaje => $Mensaje]);
                
                return view('admin.jira.show')
                ->with(compact('jira'))
                ->with(compact('jiraacciones'))
                ->with(compact('user'))
                ->with(compact('crear'));
            }
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail(Auth::id());

        $tipo_responsables = TipoResponsable::where('tire_activo', true)
                            ->where('tire_area', 'Interno')
                            ->select('tire_id', 'tire_nombre')
                            ->pluck('tire_nombre', 'tire_id')
                            ->prepend('Seleccionar', '')
                            ->sortByDesc('tire_indice')
                            ->toArray();
        //print_f($tipo_responsables, false);
        $tipo_prioridades = TipoPrioridad::where('tipr_activo', true)
                            ->select('tipr_id', 'tipr_nombre')
                            ->pluck('tipr_nombre', 'tipr_id')
                            ->prepend('Seleccionar', '')
                            ->sortByDesc('tipr_indice')
                            ->toArray();               

        $tipo_jiras = TipoJira::where('tiji_activo', true)
                            ->select(DB::raw('tiji_id, CONCAT(tiji_sistema, "-", tiji_nombre) as tiji_nombre'))
                            ->pluck('tiji_nombre', 'tiji_id')
                            ->prepend('Seleccionar', '')
                            ->sortByDesc('tiji_indice')
                            ->toArray();     

        $tipo_jiras = TipoJira::where('tiji_activo', true);
        if(!$user->hasRole('admin')){
            $TiposJiras = TipoJiraUser::join('users', 'users.id', '=', 'tipo_jiras_users.user_id')
                                ->where('users.id', $user->id)
                                ->select('tiji_id')
                                ->get()
                                ->toArray();              
            $tipo_jiras = $tipo_jiras->wherein('tipo_jiras.tiji_id', $TiposJiras);
        }
        $tipo_jiras = $tipo_jiras->select(DB::raw('tiji_id, CONCAT(tiji_sistema, "-", tiji_nombre) as tiji_nombre'))
                            ->pluck('tiji_nombre', 'tiji_id')
                            ->prepend('Seleccionar', '')
                            ->sortByDesc('tiji_indice')
                            ->toArray();
        $jira = Jira::where('jiras.jira_id', $id)
        ->join('tipo_estados','jiras.ties_id', '=', 'tipo_estados.ties_id')
        ->join('versiones','jiras.vers_id', '=', 'versiones.vers_id')
        ->join('tipo_prioridades','jiras.tipr_id', '=', 'tipo_prioridades.tipr_id')
        ->join('tipo_responsables','jiras.tire_id', '=', 'tipo_responsables.tire_id')
        ->join('tipo_jiras','jiras.tiji_id', '=', 'tipo_jiras.tiji_id')
        ->join('users','jiras.user_id', '=', 'users.id')
        ->select('jiras.jira_id', 'jiras.jira_codigo', 'jiras.jira_asunto', 'jiras.jira_descripcion', 
                'tipo_responsables.tire_id', 'tipo_prioridades.tipr_id',  
                'tipo_jiras.tiji_id', 'jiras.jira_fecha', 'users.name as user_nombre')
        //->toSql();
        //print_f($jira);
        ->get()->first();

        $incidentes = new Incidente();
        $IncidentesShow = $incidentes->ObtenerIncidentes($jira);

        $JiraUpdate = Jira::findOrFail($jira->jira_id);
        if ($IncidentesShow->count() > 0) {
            $JiraUpdate->jira_reportado = true;
            $tipoMensaje = 'success';
            $Mensaje = 'El jira ha sido creado y reportado al hospital.';
        }
        else{
            $JiraUpdate->jira_reportado = false;
            $tipoMensaje = 'warning';
            $Mensaje = 'El jira ha sido creado, pero no fue reportado porque no existen ticket asociados en la mesa de ayuda.';
        }
        $JiraUpdate->save();

        session([$tipoMensaje => $Mensaje]);

        return view('admin.jira.edit')
                        ->with(compact('jira'))
                        ->with(compact('tipo_responsables'))
                        ->with(compact('tipo_prioridades'))
                        ->with(compact('tipo_jiras'))
                        ->with($tipoMensaje, $Mensaje);
    }

    public function update(UpdateJiraRequest $request, $id)
    {
        $existe = Jira::where('jira_codigo', $request->jira_codigo)
                    ->where('jira_activo', true)
                    ->where('jira_id', '<>', $id)
                    ->count();
        if ($existe == 1){
            return redirect('admin/jira/'.$id.'/edit')->withInput()
            ->withError('error', 'El código ya existe y esta activo');
        }
        else{
            $jira = Jira::findOrFail($id);
            $jira->tire_id = $request->tire_id;
            $jira->tipr_id = $request->tipr_id;
            $jira->tiji_id = $request->tiji_id;
            $jira->jira_asunto = $request->jira_asunto;
            $jira->jira_descripcion = $request->jira_descripcion;
            $jira->jira_fecha = Carbon::parse($request->jira_fecha);
            $jira->save();
            return redirect('admin/jira')
                ->with('success', 'El jira ha sido actualizado.'); 
        }
    }

    public function destroy($id)
    {
        $incidentes = Incidente::where('jira_id', $id);
        $incidentes->delete();
        $jira = Jira::findOrFail($id);
        $Jiraaccion = JiraAccion::where('jira_id', $id);
        $Jiraaccion->delete();
        $jira->delete();
        return redirect('admin/jira')
            ->with('success', 'El jira ha sido eliminado.'); 
    }
}
