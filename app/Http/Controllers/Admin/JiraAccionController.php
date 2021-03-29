<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jira;
use App\JiraAccion;
use Illuminate\Http\Request;
use App\TipoAccionJira;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Monolog\Handler\NewRelicHandler;
use Illuminate\Support\Str;
use App\Http\Requests\JiraAccionRequest;
use File;

class JiraAccionController extends Controller
{
    function __construct()
    {
        $this->middleware('can:create jiraaccion', ['only' => ['create', 'store']]);
        $this->middleware('can:edit jiraaccion', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete jiraaccion', ['only' => ['destroy']]);
    }
    public function create($jira_id)
    {
        $user = User::findOrFail(Auth::id());
        $JiraAccion = TipoAccionJira::select('tipo_acciones_jiras.tiaj_sucesor')
            ->join('jiras_acciones', 'tipo_acciones_jiras.tiaj_id', '=', 'jiras_acciones.tiaj_id') 
            ->where('jiras_acciones.jira_id', $jira_id)  
            ->whereNotIn('tipo_acciones_jiras.tiaj_codigo', ['PRUEBAS_REGRESIVAS', 'PASO_PRODUCCION'])
            ->orderBy('jiras_acciones.jiac_id', 'DESC')
        //    ->toSql();
        //print_f($JiraAccion);
            ->first();
        $tiaj_sucesor = explode('|', $JiraAccion->tiaj_sucesor);


        $tipo_accion_jira = TipoAccionJira::where('tiaj_activo', true)
            ->select('tiaj_id', 'tiaj_nombre')
            ->where('tiaj_responsable_actual', $user->area)
            ->whereIn('tiaj_indice', $tiaj_sucesor)
            ->where('tiaj_tipo', 'Jira')
            ->orderBy('tiaj_indice', 'ASC');
            
        $cantidad = $tipo_accion_jira->count();          

        if ($cantidad == 1){
            $tiaj_id = $tipo_accion_jira->get()->first()->tiaj_id;
            $class = array('class' => 'custom-select', 'disabled' => 'disabled', 'id' => 'tiaj_nombre');
        }
        else{
            $tiaj_id = '';
            $class = array('class' => 'custom-select', 'id' => 'tiaj_nombre');
        }
        $tipo_accion_jira = $tipo_accion_jira
                            ->pluck('tiaj_nombre', 'tiaj_id')
                            ->prepend('Seleccionar', '')
                            ->toArray();

                    
            //->toSql();
            //print_f($cantidad);

        return view('admin.jiraaccion.create')
            ->with(compact('jira_id'))
            ->with(compact('tipo_accion_jira'))
            ->with(compact('tiaj_id'))
            ->with(compact('class'));
    }

    public function store(JiraAccionRequest $request)
    {
        $user = User::findOrFail(Auth::id());
        $JiraAccion = new JiraAccion();
        $JiraAccion->jira_id = $request->jira_id;
        $JiraAccion->tiaj_id = $request->tiaj_id;
        $JiraAccion->jiac_descripcion = $request->jiac_descripcion;
        $JiraAccion->jiac_observacion = $request->jiac_observacion;
        $JiraAccion->jiac_fecha = Carbon::parse($request->jiac_fecha);
        $JiraAccion->user_id = $user->id;
        $JiraAccion->jiac_activo = true;
        $JiraAccion->save();

        $Jira = Jira::findOrFail($request->jira_id);
        $Jira->ties_id = $Jira->ties_id_cambio($request->tiaj_id, true);
        $Jira->save();

        if ($File = $request->file('jiac_ruta')){

            $jira = Jira::findOrFail($request->jira_id);
            $NewName = date("YmdHis").'_'.quitar_tildes(Str::snake(TipoAccionJira::findOrFail($request->tiaj_id)->tiaj_nombre)).'.'.$File->getClientOriginalExtension();


            $path = Storage::putFileAs(
                'evidencias/jiras/'.$jira->jira_codigo, $request->file('jiac_ruta'), $NewName
            );

            $JiraAccionExt = JiraAccion::findOrFail($JiraAccion->jiac_id);
            $JiraAccionExt->jiac_ruta = $path;
            $JiraAccionExt->save();
        
        }
        
        $accion = new JiraAccion();
        $accion->jira_id = $request->jira_id;
        $accion->jiac_id = $JiraAccion->jiac_id;
        $accion->vers_id = $Jira->vers_id;
        $accion->tiaj_id = $request->tiaj_id;
        $accion->save();

        $EnvioCorreo = new EnvioCorreoController();
        $datos = $EnvioCorreo->EnvioCorreoJira($request->jira_id, $request->tiaj_id);

        return redirect('admin/jira/'.$request->jira_id)
            ->with('success', 'La acción del jira ha sido creada.'); 
    }
    public function destroy($id)
    {
        $JiraAccion = JiraAccion::findOrFail($id);
        $jira_id = $JiraAccion->jira_id;
        $JiraAccion->delete();
        return redirect('admin/jira/'.$jira_id)
            ->with('success', 'La acción del jira ha sido eliminada.'); 
    }

    public function show($id)
    {
        $jira = Jira::where('jiras_acciones.jiac_id', $id)
        ->join('tipo_estados','jiras.ties_id', '=', 'tipo_estados.ties_id')
        ->join('versiones','jiras.vers_id', '=', 'versiones.vers_id')
        ->join('tipo_prioridades','jiras.tipr_id', '=', 'tipo_prioridades.tipr_id')
        ->join('tipo_responsables','jiras.tire_id', '=', 'tipo_responsables.tire_id')
        ->join('tipo_jiras','jiras.tiji_id', '=', 'tipo_jiras.tiji_id')
        ->join('users','jiras.user_id', '=', 'users.id')
        ->join('jiras_acciones','jiras.jira_id', '=', 'jiras_acciones.jira_id')
        ->join('tipo_acciones_jiras','tipo_acciones_jiras.tiaj_id', '=', 'jiras_acciones.tiaj_id')
        ->select('jiras.jira_id', 'jiras.jira_codigo', 'jiras.jira_asunto', 'jiras.jira_descripcion', 
                 'tipo_responsables.tire_nombre', 'tipo_prioridades.tipr_nombre', 'jiac_observacion', 
                 'tipo_jiras.tiji_nombre', 'jiras.jira_fecha', 'users.name as user_nombre',
                 'tipo_acciones_jiras.tiaj_responsable_siguiente', 'tipo_acciones_jiras.tiaj_responsable_actual')
        ->get()->first();
        $user = User::findOrFail(Auth::id());        
//        print_f($jira);
        $jiraaccion = JiraAccion::where('jiras_acciones.jiac_id', $id)
        ->join('tipo_acciones_jiras', 'jiras_acciones.tiaj_id', '=',  'tipo_acciones_jiras.tiaj_id')
        ->join('users', 'jiras_acciones.user_id', '=',  'users.id')
        ->select('jiras_acciones.jiac_id', 'tipo_acciones_jiras.tiaj_nombre', 
            'jiras_acciones.jiac_descripcion', 'jiras_acciones.jiac_fecha', 
            'users.name as user_nombre', 'jiras_acciones.jiac_ruta', 'jiac_observacion')
        ->get()->first();

        //print_f($jiraaccion);
        //print_f($jira->jira_asunto, true); 
        return view('admin.jiraaccion.show')->with(compact('jira'))->with(compact('jiraaccion'))->with(compact('user'));

    }

    public function edit($id)
    {
        $user = User::findOrFail(Auth::id());
        $jiraaccion = JiraAccion::join('tipo_acciones_jiras', 'tipo_acciones_jiras.tiaj_id', '=', 'jiras_acciones.tiaj_id') 
            ->join('jiras', 'jiras.jira_id', '=', 'jiras_acciones.jira_id') 
            ->join('users', 'users.id', '=', 'jiras_acciones.user_id')
            ->select('jiras_acciones.jiac_id', 'jiras.jira_id', 'jiras.jira_codigo', 'tipo_acciones_jiras.tiaj_nombre', 'jiras_acciones.jiac_descripcion', 
                        'tipo_acciones_jiras.tiaj_id', 'jiras.jira_fecha', 'users.name as user_nombre', 'jiras_acciones.jiac_ruta', 'jiac_observacion',
                        'tipo_acciones_jiras.tiaj_responsable_siguiente', 'tipo_acciones_jiras.tiaj_responsable_actual', 'jiras_acciones.jiac_fecha') 
            ->where('jiras_acciones.jiac_id', $id)  
//            ->toSql();
            ->get()
            ->first();
//        print_f($jiraaccion, true, true);
        return view('admin.jiraaccion.edit')
                ->with(compact('jiraaccion'));
    }

    public function update(JiraAccionRequest $request, $id)
    {
        //$JiraAccionShow = JiraAccion::where('jiras_acciones.jiac_id', '$id')
        //                ->join('tipo_acciones_jiras','tipo_acciones_jiras.tiaj_id', '=', 'jiras_acciones.tiaj_id')
        //                ->toSql();
        //print_f($JiraAccionShow);
        $user = User::findOrFail(Auth::id());
        $JiraAccion = JiraAccion::findOrFail($id);
        $JiraAccion->jira_id = $request->jira_id;
        $JiraAccion->jiac_descripcion = $request->jiac_descripcion;
        $JiraAccion->jiac_observacion = $request->jiac_observacion;
        $JiraAccion->jiac_fecha = Carbon::parse($request->jiac_fecha);
        $JiraAccion->user_id = $user->id;
        $JiraAccion->jiac_activo = true;
        $JiraAccion->save();

        //print_f($request->tiaj_nombre);

        if ($File = $request->file('jiac_ruta')){

            $jira = Jira::findOrFail($request->jira_id);
            $NewName = date("YmdHis").'_'.quitar_tildes(Str::snake(TipoAccionJira::findOrFail($request->tiaj_id)->tiaj_nombre)).'.'.$File->getClientOriginalExtension();


            $path = Storage::putFileAs(
                'evidencias/jiras/'.$jira->jira_codigo, $request->file('jiac_ruta'), $NewName
            );

            $JiraAccionExt = JiraAccion::findOrFail($JiraAccion->jiac_id);
            $JiraAccionExt->jiac_ruta = $path;
            $JiraAccionExt->save();
        
        }

        return redirect('admin/jira/'.$request->jira_id)
            ->with('success', 'La acción del jira ha sido actualizado.'); 
    }

    public function download($id)
    {
        $JiraAccion = JiraAccion::findOrFail($id);

    
        return Storage::download($JiraAccion->jiac_ruta);
    }

}
