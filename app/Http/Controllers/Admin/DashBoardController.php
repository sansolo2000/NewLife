<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jira;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Version;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashBoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($area = 1)
    {
        $user = User::findOrFail(Auth::id());
        if ($area >= 1 && $area <= 5){
            $menu = $area;
            $MaxJiras = Jira::join('jiras_acciones', 'jiras.jira_id', '=', 'jiras_acciones.jira_id')
                            ->select(DB::raw('max(jiras_acciones.jiac_id) as Jiras'))
                            ->groupBy('jiras.jira_id')
                            ->get();
            $Jiras = Jira::join('jiras_acciones', 'jiras.jira_id', '=', 'jiras_acciones.jira_id')
                            ->join('tipo_jiras', 'tipo_jiras.tiji_id', '=', 'jiras.tiji_id')
                            ->join('tipo_acciones_jiras', 'jiras_acciones.tiaj_id', '=', 'tipo_acciones_jiras.tiaj_id')
                        ->wherein('jiras_acciones.jiac_id', $MaxJiras);

            
            //            $JirasAcciones = $JirasAcciones->select('jiras_acciones.jiac_')

            $Versiones = Version::join('versiones_acciones', 'versiones.vers_id', '=', 'versiones_acciones.vers_id')
                            ->join('tipo_acciones_jiras', 'versiones_acciones.tiaj_id', '=', 'tipo_acciones_jiras.tiaj_id')
                            ->join('jiras', 'jiras.vers_id', '=', 'versiones.vers_id')
                            ->join('jiras_acciones', 'jiras.jira_id', '=', 'jiras_acciones.jira_id')
                            ->join('tipo_jiras', 'tipo_jiras.tiji_id', '=', 'jiras.tiji_id')
                            ->wherein('jiras_acciones.jiac_id', $MaxJiras);
            $JirasAcciones = clone $Jiras;
            $JirasAcciones = $JirasAcciones->select('jiras.jira_id', 'jiras_acciones.jiac_fecha', 'jiras.jira_codigo', 'jiras_acciones.jiac_descripcion')
                                            ->where('tipo_acciones_jiras.tiaj_responsable_siguiente', $user->area)
                                            ->where('jiras_acciones.jiac_fecha', '>=', Carbon::now()->subMonths(1)->toDateTimeString());
            //print_f($Jiras->count());
            $VersionesAcciones = clone $Versiones;
            $VersionesAcciones = $VersionesAcciones->where('versiones.vers_id', '<>', 1)
                            ->where('tipo_acciones_jiras.tiaj_responsable_actual', $user->area)
                            ->where('versiones_acciones.veac_fecha', '<=', Carbon::now()->subMonths(1)->toDateTimeString())
                            ->select('versiones_acciones.veac_fecha', 'versiones.vers_nombre', 'versiones_acciones.veac_nombre')
                            ->distinct();                           
//            print_f($VersionesAcciones->toSql());
//            print_f($Jiras->toSql(), false);

            if ($area == 1){
                $VersionesAcciones = $VersionesAcciones->get();
                $JirasAcciones = $JirasAcciones->get();
                $DashBoard['Jiras']['Titulo'] = 'Jiras activos';
                $DashBoard['Asignadas']['Titulo'] = 'Jiras asignados';
                $DashBoard['Diagnostico']['Titulo'] = 'Jiras en diagnóstico';
                $DashBoard['Construccion']['Titulo'] = 'Jiras en construcción';
//                print_f($Jiras->toSql());

                $Total = clone $Jiras->where('tipo_acciones_jiras.tiaj_codigo', '<>', 'PASO_PRODUCCION');
                $DashBoard['Jiras']['Cantidad'] = $Total->count();
                $Asignadas = clone $Jiras->where('tipo_acciones_jiras.tiaj_responsable_siguiente', $user->area);
                $DashBoard['Asignadas']['Cantidad'] = $Asignadas->count();
                $Diagnostico = clone $Jiras->wherein('tipo_acciones_jiras.tiaj_codigo', ['CREACION_JIRA', 
                                                                                    'SOLICITUD_INFORMACION',
                                                                                    'RESPUESTA_INFORMACION',
                                                                                    'DIAGNOSTICO_ESTIMACION',
                                                                                    'APROBACION_DIAGNOSTICO',
                                                                                    'RECHAZO_DIAGNOSTICO',
                                                                                    'CREACION_VERSION',
                                                                                    'ASIGNAR_JIRAS',
                                                                                    'SOLICITUD_CIERRE',
                                                                                    'APROBACION_VERSION',
                                                                                    'RECHAZO_VERSION']);
                $DashBoard['Diagnostico']['Cantidad'] = $Diagnostico->count();
                $Construcción = clone $Jiras->wherein('tipo_acciones_jiras.tiaj_codigo', ['CONSTRUCCION', 
                                                                                'ENTREGA_FABRICA',
                                                                                'SOLICITUD_INSTALACION',
                                                                                'APROBACION_INSTALACION',
                                                                                'INSTALACION_AMBIENTE']);
                $DashBoard['Construccion']['Cantidad'] = $Construcción->count();

            }
            if ($area == 2){
                $VersionesAcciones = $VersionesAcciones->where('tiji_sistema', 'HN')->get();
                $JirasAcciones = $JirasAcciones->where('tiji_sistema', 'HN')->get();
                $DashBoard['Jiras']['Titulo'] = 'Jiras activos';
                $DashBoard['Asignadas']['Titulo'] = 'Jiras asignados';
                $DashBoard['Diagnostico']['Titulo'] = 'Jiras en diagnóstico';
                $DashBoard['Construccion']['Titulo'] = 'Jiras en construcción';

                $Jiras = $Jiras->where('tiji_sistema', 'HN');
                $Total = clone $Jiras->where('tipo_acciones_jiras.tiaj_codigo', '<>', 'PASO_PRODUCCION');
                $DashBoard['Jiras']['Cantidad'] = $Total->count();
                $Asignadas = clone $Jiras->where('tipo_acciones_jiras.tiaj_responsable_siguiente', $user->area);
                $DashBoard['Asignadas']['Cantidad'] = $Asignadas->count();
                $Diagnostico = clone $Jiras->wherein('tipo_acciones_jiras.tiaj_codigo', ['CREACION_JIRA', 
                                                                                    'SOLICITUD_INFORMACION',
                                                                                    'RESPUESTA_INFORMACION',
                                                                                    'DIAGNOSTICO_ESTIMACION',
                                                                                    'APROBACION_DIAGNOSTICO',
                                                                                    'RECHAZO_DIAGNOSTICO',
                                                                                    'CREACION_VERSION',
                                                                                    'ASIGNAR_JIRAS',
                                                                                    'SOLICITUD_CIERRE',
                                                                                    'APROBACION_VERSION',
                                                                                    'RECHAZO_VERSION']);
                $DashBoard['Diagnostico']['Cantidad'] = $Diagnostico->count();
                $Construcción = clone $Jiras->wherein('tipo_acciones_jiras.tiaj_codigo', ['CONSTRUCCION', 
                                                                                    'ENTREGA_FABRICA',
                                                                                    'SOLICITUD_INSTALACION',
                                                                                    'APROBACION_INSTALACION',
                                                                                    'INSTALACION_AMBIENTE']);
                $DashBoard['Construccion']['Cantidad'] = $Construcción->count();
            }
            if ($area == 3){
                $VersionesAcciones = $VersionesAcciones->where('tiji_sistema', 'HN')->get();
                $JirasAcciones = $JirasAcciones->where('tiji_sistema', 'HN')->get();
                $DashBoard['Jiras']['Titulo'] = 'Versiones activas';
                $DashBoard['Asignadas']['Titulo'] = 'Versiones asignadas';
                $DashBoard['Diagnostico']['Titulo'] = 'Versiones en diagnóstico';
                $DashBoard['Construccion']['Titulo'] = 'Versiones en construcción';
        
                $Versiones = $Versiones->where('tiji_sistema', 'HN')->where('versiones.vers_id', '<>', 1);
                $Total = clone $Versiones->where('tipo_acciones_jiras.tiaj_codigo', '<>', 'PASO_PRODUCCION');
                $DashBoard['Jiras']['Cantidad'] = $Total->distinct('versiones.vers_id')->count();
                $Asignadas = clone $Versiones->where('tipo_acciones_jiras.tiaj_responsable_siguiente', $user->area);
                $DashBoard['Asignadas']['Cantidad'] = $Asignadas->distinct('versiones.vers_id')->count();
                $Diagnostico = clone $Versiones->wherein('tipo_acciones_jiras.tiaj_codigo', ['CREACION_VERSION',
                                                                                    'ASIGNAR_JIRAS',
                                                                                    'SOLICITUD_CIERRE',
                                                                                    'APROBACION_VERSION',
                                                                                    'RECHAZO_VERSION']);
                $DashBoard['Diagnostico']['Cantidad'] = $Diagnostico->distinct('versiones.vers_id')->count();
                $Construcción = clone $Versiones->wherein('tipo_acciones_jiras.tiaj_codigo', ['CONSTRUCCION', 
                                                                                    'ENTREGA_FABRICA',
                                                                                    'SOLICITUD_INSTALACION',
                                                                                    'APROBACION_INSTALACION',
                                                                                    'INSTALACION_AMBIENTE']);
                $DashBoard['Construccion']['Cantidad'] = $Construcción->distinct('versiones.vers_id')->count();
            }
            if ($area == 4){
                $VersionesAcciones = $VersionesAcciones->where('tiji_sistema', 'SAP')->get();
                $JirasAcciones = $JirasAcciones->where('tiji_sistema', 'SAP')
                //->toSql();
                ->get();
                //print_f(Carbon::now()->subMonths(1)->toDateTimeString(), false);
                //print_f($JirasAcciones);
                $DashBoard['Jiras']['Titulo'] = 'Jiras activos';
                $DashBoard['Asignadas']['Titulo'] = 'Jiras asignados';
                $DashBoard['Diagnostico']['Titulo'] = 'Jiras en diagnóstico';
                $DashBoard['Construccion']['Titulo'] = 'Jiras en construcción';

                $Jiras = $Jiras->where('tiji_sistema', 'SAP');
                $Total = clone $Jiras->where('tipo_acciones_jiras.tiaj_codigo', '<>', 'PASO_PRODUCCION');
                $DashBoard['Jiras']['Cantidad'] = $Total->count();
                $Asignadas = clone $Jiras->where('tipo_acciones_jiras.tiaj_responsable_siguiente', $user->area);
                $DashBoard['Asignadas']['Cantidad'] = $Asignadas->count();
                $Diagnostico = clone $Jiras->wherein('tipo_acciones_jiras.tiaj_codigo', ['CREACION_JIRA', 
                                                                                    'SOLICITUD_INFORMACION',
                                                                                    'RESPUESTA_INFORMACION',
                                                                                    'DIAGNOSTICO_ESTIMACION',
                                                                                    'APROBACION_DIAGNOSTICO',
                                                                                    'RECHAZO_DIAGNOSTICO',
                                                                                    'CREACION_VERSION',
                                                                                    'ASIGNAR_JIRAS',
                                                                                    'SOLICITUD_CIERRE',
                                                                                    'APROBACION_VERSION',
                                                                                    'RECHAZO_VERSION']);
                $DashBoard['Diagnostico']['Cantidad'] = $Diagnostico->count();

                $Construcción = clone $Jiras->wherein('tipo_acciones_jiras.tiaj_codigo', ['CONSTRUCCION', 
                                                                                    'ENTREGA_FABRICA',
                                                                                    'SOLICITUD_INSTALACION',
                                                                                    'APROBACION_INSTALACION',
                                                                                    'INSTALACION_AMBIENTE']);
                $DashBoard['Construccion']['Cantidad'] = $Construcción->count();
            }
            if ($area == 5){
                $VersionesAcciones = $VersionesAcciones->where('tiji_sistema', 'SAP')->get();
                $JirasAcciones = $JirasAcciones->where('tiji_sistema', 'SAP')->get();
                $DashBoard['Jiras']['Titulo'] = 'Versiones activas';
                $DashBoard['Asignadas']['Titulo'] = 'Versiones asignadas';
                $DashBoard['Diagnostico']['Titulo'] = 'Versiones en diagnóstico';
                $DashBoard['Construccion']['Titulo'] = 'Versiones en construcción';

                $Versiones = $Versiones->where('tiji_sistema', 'SAP')->where('versiones.vers_id', '<>', 1);                
                $Total = clone $Versiones->where('tipo_acciones_jiras.tiaj_codigo', '<>', 'PASO_PRODUCCION');
                $DashBoard['Jiras']['Cantidad'] = $Total->distinct('versiones.vers_id')->count();
                $Asignadas = clone $Versiones->where('tipo_acciones_jiras.tiaj_responsable_siguiente', $user->area);
                $DashBoard['Asignadas']['Cantidad'] = $Asignadas->distinct('versiones.vers_id')->count();
                $Diagnostico = clone $Versiones->wherein('tipo_acciones_jiras.tiaj_codigo', ['CREACION_VERSION',
                                                                                    'ASIGNAR_JIRAS',
                                                                                    'SOLICITUD_CIERRE',
                                                                                    'APROBACION_VERSION',
                                                                                    'RECHAZO_VERSION']);

                $DashBoard['Diagnostico']['Cantidad'] = $Diagnostico->distinct('versiones.vers_id')->count();
                $Construcción = clone $Versiones->wherein('tipo_acciones_jiras.tiaj_codigo', ['CONSTRUCCION', 
                                                                                    'ENTREGA_FABRICA',
                                                                                    'SOLICITUD_INSTALACION',
                                                                                    'APROBACION_INSTALACION',
                                                                                    'INSTALACION_AMBIENTE']);
                $DashBoard['Construccion']['Cantidad'] = $Construcción->distinct('versiones.vers_id')->count();
            }

            return view('admin.dashboard.index')
                        ->with(compact('menu'))
                        ->with(compact('DashBoard'))
                        ->with(compact('JirasAcciones'))
                        ->with(compact('VersionesAcciones'));
        }
        else{
            abort(404);
        }
    }
}
