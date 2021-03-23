<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jira;
use App\JiraAccion;
use Illuminate\Http\Request;
use App\Version;
use App\User;
use App\VersionAccion;
use App\TipoAccionJira;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VersionRequest;
use App\TipoJira;
use App\TipoVersion;
use App\TipoJiraUser;

class VersionController extends Controller
{
    function __construct()
    {
        $this->middleware('can:create version', ['only' => ['create', 'store']]);
        $this->middleware('can:edit version', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete version', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user = User::findOrFail(Auth::id());

        $VersionesOld = Version::select('versiones.vers_id', 'versiones.vers_nombre',
            'versiones.vers_fecha_creacion', 'users.name AS user_nombre',
            'tipo_acciones_jiras.tiaj_nombre', 'tipo_acciones_jiras.tiaj_indice',
            DB::raw('count(distinct(jiras.jira_id)) as cant_jiras'))
                    ->join('tipos_versiones', 'versiones.vers_id', '=', 'tipos_versiones.vers_id')
                    ->join('tipo_jiras', 'tipo_jiras.tiji_id', '=', 'tipos_versiones.tiji_id')
                    ->join('users', 'users.id', '=', 'versiones.user_id')
                    ->join('versiones_acciones', 'versiones_acciones.vers_id', '=', 'versiones.vers_id')
                    ->join('tipo_acciones_jiras', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id');



//        print_f(Auth::id(), true);
        if(!$user->hasRole('admin')){
            $TiposJiras = TipoJiraUser::join('users', 'users.id', '=', 'tipo_jiras_users.user_id')
                                ->where('users.id', $user->id)
                                ->select('tiji_id')
                                ->get()
                                ->toArray();
            $VersionesOld = $VersionesOld->leftJoin('jiras', function($join) use ($TiposJiras){
                                 $join->on('jiras.vers_id', '=', 'versiones_acciones.vers_id')
                                 ->wherein('jiras.tiji_id', $TiposJiras);
                            });
        }
        else{
            $VersionesOld = $VersionesOld->leftJoin('jiras', 'jiras.vers_id', '=', 'versiones_acciones.vers_id');
        }    


        $VersionesOld = $VersionesOld->where('versiones.vers_activo', true)
                    ->groupBY('versiones.vers_id', 'versiones.vers_nombre', 
                    'versiones.vers_fecha_creacion', 'users.name', 'tipo_acciones_jiras.tiaj_nombre',
                    'tipo_acciones_jiras.tiaj_indice')
                    ->orderBy('versiones.vers_id', 'ASC')
                    ->orderBy('tipo_acciones_jiras.tiaj_indice', 'DESC')
//                    ->toSql();
//                    print_f($VersionesOld);
            ->get();
    //    $Jiras = Jira::where()  
        $vers_id = 0;
        foreach($VersionesOld as $VersionOld){
            $TipoJiraSearch = '';
            if ($vers_id != $VersionOld->vers_id) {
                $vers_id = $VersionOld->vers_id;
                $VersionNew['vers_id'] = $VersionOld->vers_id;
                $VersionNew['vers_nombre'] = $VersionOld->vers_nombre;
                $VersionNew['vers_fecha_creacion'] = $VersionOld->vers_fecha_creacion_format();
                $VersionNew['user_nombre'] = $VersionOld->user_nombre;
                $VersionNew['tiaj_nombre'] = $VersionOld->tiaj_nombre;
                $VersionNew['tiaj_indice'] = $VersionOld->tiaj_indice;
                $VersionNew['cant_jiras'] = $VersionOld->cant_jiras;

                $TiposJiras = TipoVersion::select('tipo_jiras.tiji_sistema', 'tipo_jiras.tiji_nombre')
                            ->join('tipo_jiras', 'tipo_jiras.tiji_id', '=', 'tipos_versiones.tiji_id')
                            ->where('tipos_versiones.vers_id', '=', $VersionOld->vers_id)
                            ->get()->toArray();

                foreach($TiposJiras as $TipoJira){
                    $TipoJiraSearch .= '<li>'.$TipoJira['tiji_sistema'].'-'.$TipoJira['tiji_nombre'].'</li>';
                }
                $VersionNew['tipos_jiras'] = $TipoJiraSearch;

                $Versiones[] = $VersionNew;
            }
        }   

        return view('admin.version.index')->with(compact('Versiones'));

    }

    public function create()
    {
        $user = User::findOrFail(Auth::id());
        $TiposJiras = TipoJira::select('tiji_id', DB::raw('CONCAT(tiji_sistema, "-", tiji_nombre) as tiji_nombre'))
                            ->where('tiji_activo', true);
        if(!$user->hasRole('admin')){
            $tipo_jiras = TipoJiraUser::join('users', 'users.id', '=', 'tipo_jiras_users.user_id')
                                ->where('users.id', $user->id)
                                ->select('tiji_id')
                                ->get()
                                ->toArray();              
            $TiposJiras = $TiposJiras->wherein('tipo_jiras.tiji_id', $tipo_jiras);
        }
        $TiposJiras = $TiposJiras->get(); 
        return view('admin.version.create')
                ->with(compact('TiposJiras'));
    }

    public function store(VersionRequest $request)
    {

        $user = User::findOrFail(Auth::id());
        $version = new Version();

        $fecha = date('Y-m-d H:i:s');

        $version->vers_nombre = $request->vers_nombre; 
        $version->vers_fecha_creacion = $fecha;
        $version->vers_activo = true;
        $version->user_id = $user->id;
        $version->save();
        
        $versionaccion = new VersionAccion();
        $versionaccion->vers_id = $version->vers_id; 
        $versionaccion->tiaj_id = TipoAccionJira::tiaj_codigo_id('CREACION_VERSION');
        $versionaccion->veac_nombre = 'Creación de versión - '.$version->vers_nombre;
        $versionaccion->veac_fecha = $fecha;
        $versionaccion->veac_activo = true;
        $versionaccion->user_id = $user->id;
        $versionaccion->save();

        $TipoVersionDelete = TipoVersion::where('tipos_versiones.vers_id', $version->vers_id);
        $TipoVersionDelete->delete();

        $indice = 0;
        foreach($request->tiji as $tiji){
            $TipoVersionSearch = TipoVersion::
                            where('vers_id', $version->vers_id)
                            ->where('tiji_id', intval($tiji))
                            ->first();

            if ($TipoVersionSearch === null) {
                $TipoVersion = new TipoVersion();
                $TipoVersion->vers_id = $version->vers_id;
                $TipoVersion->tiji_id = intval($tiji);
                $TipoVersion->save();
            }
        }

        $EnvioCorreo = new EnvioCorreoController();
        $datos = $EnvioCorreo->EnvioCorreoVersion($version->vers_id, $versionaccion->veac_id, TipoAccionJira::tiaj_codigo_id('CREACION_VERSION'));

        return redirect('admin/version')
                    ->with('success', 'La versión ha sido creado.');     
    }

    public function show($id)
    {
        $user = User::findOrFail(Auth::id());

        $Version = Version::select('versiones.vers_id', 'versiones.vers_nombre', 
                    'versiones.vers_fecha_creacion', 'users.name as user_nombre',
                    'tipo_acciones_jiras.tiaj_responsable_siguiente',
                    'tipo_acciones_jiras.tiaj_nombre', 'tipo_acciones_jiras.tiaj_responsable_actual',
                    'tipo_acciones_jiras.tiaj_estado')
                    ->join('users', 'users.id', '=', 'versiones.user_id')
                    ->join('versiones_acciones', 'versiones_acciones.vers_id', '=', 'versiones.vers_id')
                    ->join('tipo_acciones_jiras', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id')
                    ->where('versiones.vers_activo', true)
                    ->where('versiones.vers_id', $id)
                    ->orderBy('versiones_acciones.veac_id', 'DESC')
                    ->get()->first();
                    //->toSql();
        //print_f($Version, false);

        $VersionesAcciones = VersionAccion::select('versiones_acciones.veac_id', 
                    'tipo_acciones_jiras.tiaj_nombre', 'tipo_acciones_jiras.tiaj_indice', 
                    'users.name as user_nombre', 'versiones_acciones.veac_nombre', 
                    'versiones_acciones.veac_ruta', 'versiones_acciones.veac_fecha', 
                    'tipo_acciones_jiras.tiaj_responsable_actual')
            ->join('tipo_acciones_jiras', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id')
            ->join('users', 'users.id', '=', 'versiones_acciones.user_id')
            ->where('versiones_acciones.veac_activo', true)
            ->where('versiones_acciones.vers_id', $id)
            ->orderBy('versiones_acciones.veac_id', 'ASC')
            ->get();
            //->toSql();

            $TipoAccionJira = TipoAccionJira::select('versiones_acciones.veac_id', 'tipo_acciones_jiras.tiaj_sucesor')
            ->join('versiones_acciones', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id') 
            ->join('jiras', 'jiras.vers_id', '=', 'versiones_acciones.vers_id')
            ->where('versiones_acciones.vers_id', $id)  
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
            ->where('versiones_acciones.vers_id', $id)  
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
        ->orderBy('tiaj_indice', 'ASC');

        //print_f($VersionesAcciones, false);                               
        $tiaj_indice = VersionAccion::join('tipo_acciones_jiras', 'versiones_acciones.tiaj_id', '=',  'tipo_acciones_jiras.tiaj_id')
                    ->where('versiones_acciones.vers_id', $id)
                    ->orderBy('versiones_acciones.veac_id', 'DESC')
                    ->select('tipo_acciones_jiras.tiaj_indice')
                    ->get()
                    ->first();
                    //->toSql();
        //print_f($tiaj_indice, false);      
        
        $cantidad = $tipo_accion_jira->count();  
        $TiposJiras = TipoJira::where('tiji_activo', true)->get(); 

        $TiposVersiones = TipoVersion::where('tipos_versiones.vers_id', $id)
                                    ->select('tiji_id')
                                    ->get()
                                    ->toArray();
        $TipoVersionNew = TipoJira::CargarTiposJiras('String');            
        foreach ($TiposVersiones as $TipoVersion){
                $TipoVersionNew[$TipoVersion['tiji_id']] = 'checked="checked"';
        }
        if ($cantidad == 0){
            $crear = false;
            if ($user->area == 'Interno'){
                $warning = 'La versión requiere atención de HLF';
            }
            if ($user->area == 'Externo'){
                $warning = 'La versión requiere atención de Indra';
            }
            session(['warning' => $warning]);
            return view('admin.version.show')
            ->with(compact('Version'))
            ->with(compact('VersionesAcciones'))
            ->with(compact('user'))
            ->with(compact('TiposJiras'))
            ->with(compact('crear'))
            ->with(compact('TipoVersionNew'));
        }
        else{
            $crear = true;
            return view('admin.version.show')
                    ->with(compact('Version'))
                    ->with(compact('VersionesAcciones'))
                    ->with(compact('user'))
                    ->with(compact('crear'))
                    ->with(compact('TiposJiras'))
                    ->with(compact('TipoVersionNew'));
        }        
    }

    
    public function edit($id)
    {
        $version = Version::select('versiones.vers_id', 'versiones.vers_nombre', 
                    'versiones.vers_fecha_creacion', 'users.name as user_nombre',
                    'tipo_acciones_jiras.tiaj_responsable_siguiente', 'tipo_acciones_jiras.tiaj_nombre')
                    ->join('users', 'users.id', '=', 'versiones.user_id')
                    ->join('versiones_acciones', 'versiones_acciones.vers_id', '=', 'versiones.vers_id')
                    ->join('tipo_acciones_jiras', 'tipo_acciones_jiras.tiaj_id', '=', 'versiones_acciones.tiaj_id')
                    ->where('versiones.vers_activo', true)
                    ->where('versiones.vers_id', $id)
                    ->orderBy('tipo_acciones_jiras.tiaj_id', 'DESC')
//                    ->toSql();
//                    print_f($version);
                    ->get()->first();
        $TiposVersiones = TipoVersion::where('tipos_versiones.vers_id', $id)
                    ->select('tiji_id')
                    ->get()
                    ->toArray();
        $TipoVersionNew = TipoJira::CargarTiposJiras('String');          
        foreach ($TiposVersiones as $TipoVersion){
            $TipoVersionNew[$TipoVersion['tiji_id']] = 'checked="checked"';
        }
        $TiposJiras = TipoJira::select('tiji_id', DB::raw('CONCAT(tiji_sistema, "-", tiji_nombre) as tiji_nombre'))
                            ->where('tiji_activo', true)->get(); 
        return view('admin.version.edit')
                    ->with(compact('TiposJiras'))
                    ->with(compact('version'))
                    ->with(compact('TipoVersionNew'));
    }

    public function update(VersionRequest $request, $id)
    {
        $version = Version::findOrFail($id);
        $version->vers_nombre = $request->vers_nombre; 

        $version->save();

        $TiposVersiones = TipoJira::CargarTiposJiras();
        foreach($request->tiji as $tiji){
            $TiposVersiones[intval($tiji)] = true;
        }
        foreach($TiposVersiones as $Ind => $TipoVersion){
            if ($TipoVersion){
                $TipoVersionSearch = TipoVersion::
                                    where('vers_id', $version->vers_id)
                                    ->where('tiji_id', $Ind)
                                    ->first();
                if ($TipoVersionSearch === null) {
                    $TipoVersion = new TipoVersion;
                    $TipoVersion->vers_id = $version->vers_id;
                    $TipoVersion->tiji_id   = $Ind;
                    $TipoVersion->save();
                }

            }
            else{
                $TipoVersionDelete = TipoVersion::where('vers_id', $version->vers_id)
                                ->where('tiji_id', $Ind);
                $TipoVersionDelete->delete();
            }
        }
        return redirect('admin/version')
            ->with('success', 'La versión ha sido actualizado.');  
    }

    public function destroy($id){
        $VersionesAcciones = VersionAccion::where('vers_id', $id);
        $VersionesAcciones->delete();

        $TipoVersion = TipoVersion::where('vers_id', $id);
        $TipoVersion->delete();

        $version = Version::findOrFail($id);
        $version->delete();
        return redirect('admin/version')
            ->with('success', 'La versión ha sido borrada.');  

    }

}
