<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\TipoAccionJira;
use App\VersionAccion;
use App\Version;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Jira;
use App\JiraAccion;
use App\TipoEstado;
use App\TipoVersion;

class VersionAccionController extends Controller

{
    function __construct()
    {
        $this->middleware('can:create versionaccion', ['only' => ['create', 'store']]);
        $this->middleware('can:edit versionaccion', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete versionaccion', ['only' => ['destroy']]);
    }

    public function show($vers_id, $veac_id)
    {
        $user = User::findOrFail(Auth::id());

        $tiaj_id = TipoAccionJira::select('tipo_acciones_jiras.tiaj_id')
            ->join('versiones_acciones', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id') 
            ->where('versiones_acciones.veac_id', $veac_id)  
            ->where('tiaj_tipo', 'Version')
//            ->orderBy('tiaj_indice', 'DESC')
//            ->toSql();
            ->first()
            ->tiaj_id;
//        print_f($tiaj_id);

        $tipo_accion_jira = TipoAccionJira::where('tiaj_activo', true)
                            ->select('tiaj_id', 'tiaj_nombre')
                            ->where('tiaj_id', $tiaj_id)
                            ->where('tiaj_tipo', 'Version')
                            ->orderBy('tiaj_indice', 'ASC');
//        ->toSql();
        $Version = Version::select('tipo_acciones_jiras.tiaj_nombre', 'tipo_acciones_jiras.tiaj_id',
                                    'versiones_acciones.veac_nombre', 'versiones_acciones.veac_observacion', 'versiones_acciones.veac_fecha')
                    ->join('versiones_acciones', 'versiones.vers_id', '=', 'versiones_acciones.vers_id')
                    ->join('tipo_acciones_jiras', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id')
                    ->where('veac_id', $veac_id)->get()->first();
//        print_f($tipo_accion_jira);
        $cantidad = $tipo_accion_jira->count();  

        if ($cantidad == 1){
            $tiaj_id = $tipo_accion_jira->get()->first()->tiaj_id;
            $class = array('class' => 'custom-select', 'disabled' => 'disabled', 'id' => 'tiaj_nombre');
        }
        else{
            $tiaj_id = '';
            $class = array('class' => 'custom-select', 'id' => 'tiaj_nombre');
        }


        if ($tiaj_id == TipoAccionJira::tiaj_codigo_id('ASIGNAR_JIRAS')){
            return $this->toassign($vers_id, false);
        }
        else{
            $tipo_accion_jira = $tipo_accion_jira
            ->pluck('tiaj_nombre', 'tiaj_id')
            ->prepend('Seleccionar', '')
            ->toArray();


            return view('admin.versionaccion.show')
                ->with(compact('veac_id'))
                ->with(compact('vers_id'))
                ->with(compact('Version'))
                ->with(compact('tipo_accion_jira'))
                ->with(compact('tiaj_id'))
                ->with(compact('class'));
        }        
    }
    public function create($vers_id)
    {
        $user = User::findOrFail(Auth::id());

        $TipoAccionJira = TipoAccionJira::select('versiones_acciones.veac_id', 'tipo_acciones_jiras.tiaj_sucesor')
            ->join('versiones_acciones', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id') 
            ->join('jiras', 'jiras.vers_id', '=', 'versiones_acciones.vers_id')
            ->where('versiones_acciones.vers_id', $vers_id)  
            ->where('tiaj_tipo', 'Version')
            ->groupBy('versiones_acciones.veac_id', 'tipo_acciones_jiras.tiaj_sucesor')
            ->orderBy('versiones_acciones.veac_id', 'DESC');
            //->toSql();
            //->tiaj_sucesor;

        //print_f($TipoAccionJira);
        if ($TipoAccionJira->count()>0){
            $tiaj_sucesor = $TipoAccionJira->first()->tiaj_sucesor;   
        }
        else{
            $TipoAccionJira = TipoAccionJira::select('tipo_acciones_jiras.tiaj_sucesor')
            ->join('versiones_acciones', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id') 
            ->where('versiones_acciones.vers_id', $vers_id)  
            ->where('tiaj_tipo', 'Version')
            ->orderBy('versiones_acciones.veac_id', 'DESC')
            //->toSql();
            ->get();
            //->first()
            //->tiaj_sucesor;
            //print_f($TipoAccionJira);
            $tiaj_sucesor = $TipoAccionJira->first()->tiaj_sucesor;
        }        
        $tiaj_sucesor = explode('|', $tiaj_sucesor);

        $tipo_accion_jira = TipoAccionJira::where('tiaj_activo', true)
        ->select('tiaj_id', 'tiaj_nombre')
        ->where('tiaj_responsable_actual', $user->area)
        ->whereIn('tiaj_indice', $tiaj_sucesor)
        ->where('tiaj_tipo', 'Version')
        ->orderBy('tiaj_indice', 'ASC');
//        ->toSql();
        
//        print_f($tipo_accion_jira);
        $cantidad = $tipo_accion_jira->count();  

        if ($cantidad == 1){
            $tiaj_id = $tipo_accion_jira->get()->first()->tiaj_id;
            $class = array('class' => 'custom-select', 'disabled' => 'disabled', 'id' => 'tiaj_nombre');
        }
        else{
            $tiaj_id = '';
            $class = array('class' => 'custom-select', 'id' => 'tiaj_nombre');
        }


        if ($tiaj_id == TipoAccionJira::tiaj_codigo_id('ASIGNAR_JIRAS')){
            return $this->toassign($vers_id, true);
        }
        else{
            $tipo_accion_jira = $tipo_accion_jira
            ->pluck('tiaj_nombre', 'tiaj_id')
            ->prepend('Seleccionar', '')
            ->toArray();


            return view('admin.versionaccion.create')
                ->with(compact('vers_id'))
                ->with(compact('tipo_accion_jira'))
                ->with(compact('tiaj_id'))
                ->with(compact('class'));
        }
    }

    public function store(Request $request)
    {
        //print_f($request->tiaj_id);
        $user = User::findOrFail(Auth::id());

        $versionaccion = new VersionAccion();
        $versionaccion->vers_id = $request->vers_id; 
        $versionaccion->tiaj_id = $request->tiaj_id;
        $versionaccion->veac_nombre = $request->veac_nombre;
        $versionaccion->veac_observacion = $request->veac_observacion;
        $versionaccion->veac_fecha = Carbon::parse($request->veac_fecha);
        $versionaccion->veac_activo = true;
        $versionaccion->user_id = $user->id;
        $versionaccion->save();

        $tiaj_codigo = TipoAccionJira::findOrFail($request->tiaj_id)->tiaj_codigo;

        if ($tiaj_codigo != 'ASIGNAR_JIRAS'){
            $jiras = Jira::where('vers_id', $request->vers_id)
                    ->select('jira_id')->get()->toArray();
            foreach ($jiras as $jira){
                $JiraAccion = new JiraAccion();
                $JiraAccion->jira_id = $jira['jira_id'];
                $JiraAccion->tiaj_id = $request->tiaj_id;
                $JiraAccion->jiac_descripcion = $tiaj_codigo;
                $JiraAccion->jiac_fecha = Carbon::parse($request->veac_fecha);
                $JiraAccion->user_id = $user->id;
                $JiraAccion->jiac_activo = true;
                $JiraAccion->save();
            }
        }

        if ($File = $request->file('jiac_ruta')){

            $version = Version::findOrFail($request->vers_id);
            $NewName = date("YmdHis").'_'.quitar_tildes(Str::snake(TipoAccionJira::findOrFail($request->tiaj_id)->tiaj_nombre)).'.'.$File->getClientOriginalExtension();


            $path = Storage::putFileAs(
                'evidencias/version/'.$version->vers_nombre, $request->file('jiac_ruta'), $NewName
            );

            $VersionAccionExt = VersionAccion::findOrFail($versionaccion->veac_id);
            $VersionAccionExt->veac_ruta = $path;
            $VersionAccionExt->save();
        
        }

        $EnvioCorreo = new EnvioCorreoController();
        $datos = $EnvioCorreo->EnvioCorreoVersion($request->vers_id, $versionaccion->veac_id, $request->tiaj_id);

        return redirect('admin/version/'.$request->vers_id)
                    ->with('success', 'La acción de la versión ha sido creada.'); 
    }
    public function toassign($id, $enabled)
    {
        $version = Version::where('versiones.vers_id', $id)->first();
        $TipoVersion = TipoVersion::where('tipos_versiones.vers_id', $id)
                                ->select('tipos_versiones.tiji_id')
                                ->get()
                                ->toArray();
        $Jiras = Jira::whereIn('jiras.vers_id', array(1, $id))
                    ->orderBy('jira_codigo')
                    ->wherein('tiji_id', $TipoVersion)
                    ->select('jiras.jira_id', 'jiras.jira_codigo', 'jiras.vers_id')
                    ->get();
//                    ->toSql();
//        print_f($Jiras);
        $vers_id = $id;

        $indice = 0;      
        $columna1 = '';      
        $columna2 = '';      
        $columna3 = '';      
        $columna4 = '';
        $disabled = '';
        $class_fecha = array("id" => "veac_fecha", "class" => "form-control");    
        if ($enabled == false){
            $disabled = 'disabled="disabled"';    
            $class_fecha = array("id" => "veac_fecha", "class" => "form-control", "disabled" => "disabled");
        }  
        foreach($Jiras as $Jira){
            $checked = ($Jira->vers_id == 1) ? '': ' checked';
            $indice++;
            if ($indice==1){
                $columna1.= '<div class="form-check">';
                $columna1.= '   <input id="check_'.$Jira->jira_id.'" name="check_'.$Jira->jira_id.'" class="form-check-input" type="checkbox"'.$checked.' '.$disabled.'>';
                $columna1.= '   <label class="form-check-label">'.$Jira->jira_codigo.'</label>';
                $columna1.= '</div>';
            }
            if ($indice==2){
                $columna2.= '<div class="form-check">';
                $columna2.= '   <input id="check_'.$Jira->jira_id.'" name="check_'.$Jira->jira_id.'" class="form-check-input" type="checkbox"'.$checked.' '.$disabled.'>';
                $columna2.= '   <label class="form-check-label">'.$Jira->jira_codigo.'</label>';
                $columna2.= '</div>';
            }
            if ($indice==3){
                $columna3.= '<div class="form-check">';
                $columna3.= '   <input id="check_'.$Jira->jira_id.'" name="check_'.$Jira->jira_id.'" class="form-check-input" type="checkbox"'.$checked.' '.$disabled.'>';
                $columna3.= '   <label class="form-check-label">'.$Jira->jira_codigo.'</label>';
                $columna3.= '</div>';
            }
            if ($indice==4){
                $columna4.= '<div class="form-check">';
                $columna4.= '   <input id="check_'.$Jira->jira_id.'" name="check_'.$Jira->jira_id.'" class="form-check-input" type="checkbox"'.$checked.' '.$disabled.'>';
                $columna4.= '   <label class="form-check-label">'.$Jira->jira_codigo.'</label>';
                $columna4.= '</div>';
                $indice=0;
            }
        }            
        return view('admin.versionaccion.toassign')
                    ->with(compact('version'))
                    ->with(compact('columna1'))
                    ->with(compact('columna2'))
                    ->with(compact('columna3'))
                    ->with(compact('columna4'))
                    ->with(compact('vers_id'))
                    ->with(compact('class_fecha'))
                    ->with(compact('disabled'));

    }

    public function assigned(Request $request){
        $user =  User::findOrFail(Auth::id());
        $jiras = Jira::whereIn('jiras.vers_id', array(1, $request->vers_id))
                ->orderBy('jira_codigo')
                ->select('jiras.jira_id', 'jiras.jira_codigo', 'jiras.vers_id')
                ->get();
        //print_f($request);
        $total = 0;
        $asignados = 0;
        $Observaciones = '';
        $tiaj_id_AsignarJiras = TipoAccionJira::where('tiaj_codigo', 'ASIGNAR_JIRAS')->first()->tiaj_id;
        foreach($jiras as $jira){
            $total++;
            $JiraActualizar = Jira::findOrFail($jira->jira_id);
            
            //print_f($ties_id);      
            if ($request['check_'.$jira->jira_id]){
                $JiraActualizar->vers_id = $request->vers_id;
                $JiraActualizar->ties_id = $JiraActualizar->ties_id_cambio($tiaj_id_AsignarJiras, true);
                $Observaciones .= $JiraActualizar->jira_codigo.'|';
                $asignados++;
            }
            else{
                $JiraActualizar->ties_id = $JiraActualizar->ties_id_cambio($tiaj_id_AsignarJiras, false);
                $JiraActualizar->vers_id = 1;
            }
            $JiraActualizar->save();
        }

        $version = Version::where('versiones.vers_id', $request->vers_id)->first();
        $Jiras = Jira::whereIn('jiras.vers_id', array(1, $request->vers_id))
                    ->orderBy('jira_codigo')
                    ->select('jiras.jira_id', 'jiras.jira_codigo', 'jiras.vers_id')
                    ->get();


        $indice = 0;      
        $columna1 = '';      
        $columna2 = '';      
        $columna3 = '';      
        $columna4 = '';      
        foreach($Jiras as $Jira){
            $checked = ($Jira->vers_id == 1) ? '': ' checked';
            $indice++;
            if ($indice==1){
                $columna1.= '<div class="form-check">';
                $columna1.= '   <input id="check_'.$Jira->jira_id.'" name="check_'.$Jira->jira_id.'" class="form-check-input" type="checkbox"'.$checked.'>';
                $columna1.= '   <label class="form-check-label">'.$Jira->jira_codigo.'</label>';
                $columna1.= '</div>';
            }
            if ($indice==2){
                $columna2.= '<div class="form-check">';
                $columna2.= '   <input id="check_'.$Jira->jira_id.'" name="check_'.$Jira->jira_id.'" class="form-check-input" type="checkbox"'.$checked.'>';
                $columna2.= '   <label class="form-check-label">'.$Jira->jira_codigo.'</label>';
                $columna2.= '</div>';
            }
            if ($indice==3){
                $columna3.= '<div class="form-check">';
                $columna3.= '   <input id="check_'.$Jira->jira_id.'" name="check_'.$Jira->jira_id.'" class="form-check-input" type="checkbox"'.$checked.'>';
                $columna3.= '   <label class="form-check-label">'.$Jira->jira_codigo.'</label>';
                $columna3.= '</div>';
            }
            if ($indice==4){
                $columna4.= '<div class="form-check">';
                $columna4.= '   <input id="check_'.$Jira->jira_id.'" name="check_'.$Jira->jira_id.'" class="form-check-input" type="checkbox"'.$checked.'>';
                $columna4.= '   <label class="form-check-label">'.$Jira->jira_codigo.'</label>';
                $columna4.= '</div>';
                $indice=0;
            }
        }
        $versionaccionupdate = VersionAccion::where('versiones_acciones.vers_id', $version->vers_id)
                        ->where('versiones_acciones.tiaj_id', TipoAccionJira::tiaj_codigo_id('ASIGNAR_JIRAS'))
                        ->update(['versiones_acciones.veac_activo' => false]);
        $versionaccion = new VersionAccion();
        $versionaccion->vers_id = $version->vers_id; 
        $versionaccion->tiaj_id = TipoAccionJira::tiaj_codigo_id('ASIGNAR_JIRAS');
        $versionaccion->veac_nombre = 'Asociación de jiras a la versión: '.$version->vers_nombre.' '. $asignados.' de '. $total.' Jiras';
        $versionaccion->veac_fecha = Carbon::parse($request->veac_fecha);
        $versionaccion->veac_observacion = $Observaciones;
        $versionaccion->veac_activo = true;
        $versionaccion->user_id = $user->id;
        $versionaccion->save();

        $EnvioCorreo = new EnvioCorreoController();
        $datos = $EnvioCorreo->EnvioCorreoVersion($version->vers_id, $versionaccion->veac_id, TipoAccionJira::tiaj_codigo_id('ASIGNAR_JIRAS'));


        return redirect('admin/version/'.$request->vers_id)
            ->with('success', 'Se ha realizado la asignación de jiras');
    }

    public function edit($vers_id, $veac_id)
    {
        $VersionAccion = VersionAccion::findOrFail($veac_id);
        if ($VersionAccion->tiaj_id == TipoAccionJira::tiaj_codigo_id('ASIGNAR_JIRAS')){
            return $this->toassign($VersionAccion->vers_id, true);
        }
        else{
 
            $versionaccion = VersionAccion::select('versiones.vers_id', 'versiones.vers_nombre', 
                        'versiones.vers_fecha_creacion', 'users.name as user_nombre',
                        'tipo_acciones_jiras.tiaj_responsable_siguiente', 'tipo_acciones_jiras.tiaj_nombre',
                        'tipo_acciones_jiras.tiaj_id', 'versiones_acciones.veac_nombre',
                        'versiones_acciones.veac_ruta', 'versiones_acciones.veac_id',
                        'versiones_acciones.veac_observacion', 'versiones_acciones.veac_fecha')
                        ->join('versiones', 'versiones.vers_id', '=', 'versiones_acciones.vers_id')
                        ->join('users', 'versiones.user_id', '=', 'users.id')
                        ->join('tipo_acciones_jiras', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id')
                        ->where('versiones.vers_activo', true)
                        ->where('versiones_acciones.veac_id', $veac_id)
                        ->orderBy('tipo_acciones_jiras.tiaj_id', 'DESC')
                        ->get()->first();
                        //->toSql();
            //print_f($versionaccion);
            return view('admin.versionaccion.edit')
                            ->with(compact('versionaccion'));
        }
    }

    public function update(Request $request, $vers_id, $veac_id)
    {
        //$JiraAccionShow = JiraAccion::where('jiras_acciones.jiac_id', '$id')
        //                ->join('tipo_acciones_jiras','tipo_acciones_jiras.tiaj_id', '=', 'jiras_acciones.tiaj_id')
        //                ->toSql();
        //print_f($id);
        $user = User::findOrFail(Auth::id());
        $VersionAccion = VersionAccion::findOrFail($veac_id);
        $VersionAccion->veac_nombre = $request->veac_nombre;
        $VersionAccion->veac_observacion = $request->veac_observacion;        
        $VersionAccion->veac_fecha = Carbon::parse($request->veac_fecha);
        $VersionAccion->user_id = $user->id;
        $VersionAccion->save();

        //print_f($request->tiaj_nombre);

        if ($File = $request->file('veac_ruta')){

            $Version = Version::findOrFail($vers_id);
            $NewName = date("YmdHis").'_'.quitar_tildes(Str::snake(TipoAccionJira::findOrFail($request->tiaj_id)->tiaj_nombre)).'.'.$File->getClientOriginalExtension();


            $path = Storage::putFileAs(
                'evidencias/version/'.$Version->vers_nombre, $request->file('veac_ruta'), $NewName
            );

            $VersionAccionExt = VersionAccion::findOrFail($veac_id);
            $VersionAccionExt->veac_ruta = $path;
            $VersionAccionExt->save();
        
        }

        return redirect('admin/version/'.$vers_id)
            ->with('success', 'La acción de la versión ha sido actualizado.'); 
    }

    public function destroy($vers_id, $veac_id)
    {
        $VersionAccion = VersionAccion::FindOrFail($veac_id);
        $vers_id = $VersionAccion->vers_id;
        $VersionAccion->delete();
        return redirect('admin/version/'.$vers_id)
            ->with('success', 'La accion de la versión ha sido eliminada.'); 
    }

    public function download($vers_id, $veac_id)
    {
        $VersionAccion = VersionAccion::findOrFail($veac_id);

    
        return Storage::download($VersionAccion->veac_ruta);
    }
}
