<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Incidente;
use Illuminate\Http\Request;
use App\Mail\EnvioEstadosMailable;
use Illuminate\Support\Facades\Mail;
use App\Mensaje;
use App\Jira;
use App\TipoAccionJira;
use App\TipoVersion;
use App\User;
use Illuminate\Cache\Console\ForgetCommand;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Switch_;
use App\Version;
use App\VersionAccion;

class EnvioCorreoController extends Controller
{
   public $MailAccept = false;

    function EnvioCorreoJira($jira_id, $tiaj_id){
        $jira = Jira::FindOrFail($jira_id);
        $TipoAccionJira = TipoAccionJira::FindOrFail($tiaj_id);
        $UserJira = User::FindOrFail($jira->user_id);
        switch ($TipoAccionJira->tiaj_estado){
            case "Informativo":
                $UsersInformativos = User::all();
                break; 
            case "Pregunta":
            case "Respuesta":
                $Users = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
                            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->select('users.id')
                            ->where('permissions.name', '=', 'create jiraaccion')
                            ->get()
                            ->toArray();
                $UsersInformativos1 = User::select('users.id', 'users.name', 'users.email', 'users.area')
                            ->whereNotIn('users.id', $Users);

                $UsersInformativos2 = User::select('users.id', 'users.name', 'users.email', 'users.area')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
                            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->whereIn('users.id', $Users)
                            ->where('area', '=', $TipoAccionJira->tiaj_responsable_actual)
                            ->where('permissions.name', '=', 'create jiraaccion');
                $UsersInformativos = $UsersInformativos1->union($UsersInformativos2)->get();
                $UsersDestinatario = User::select('users.id', 'users.name', 'users.email', 'users.area')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
                            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->whereIn('users.id', $Users)
                            ->distinct()
                            ->where('users.area', '=', $TipoAccionJira->tiaj_responsable_siguiente)
                            ->get();
                break;
        }
        
        if (isset($UsersInformativos) && $UsersInformativos->count() > 0){
            foreach ($UsersInformativos as $User){
                $Estado = false;
                $correo = new EnvioEstadosMailable();
                switch ($TipoAccionJira->tiaj_codigo) {
                    case 'CREACION_JIRA':
                        $correo->subject = 'Creación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->CorreoCreacionJira($jira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'SOLICITUD_INFORMACION':
                        $correo->subject = 'Consulta sobre el Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoInformativo($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'RESPUESTA_INFORMACION':
                        $correo->subject = 'Respuesta del HLF a la consulta del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoInformativo($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'DIAGNOSTICO_ESTIMACION':
                        $correo->subject = 'Diagnostico y estimación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoInformativo($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'APROBACION_DIAGNOSTICO':
                        $correo->subject = 'Aprobación Diagnóstico del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoInformativo($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'RECHAZO_DIAGNOSTICO':
                        $correo->subject = 'Rechazo Diagnóstico del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoInformativo($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'VALIDACION_INDRA':
                        $correo->subject = 'Validación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'APROBACION_VALIDACION_INDRA':
                        $correo->subject = 'Aprobación de validación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'RECHAZO_VALIDACION_HLF':
                        $correo->subject = 'Rechazo de validación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                            
                }
                if ($this->MailAccept && $Estado){
                    Mail::to($User['email'])->send($correo);
                }
            }
        }
        $User = '';
        if (isset($UsersDestinatario) && $UsersDestinatario->count() > 0){
            foreach ($UsersDestinatario as $User){
                $correo = new EnvioEstadosMailable();
                switch ($TipoAccionJira->tiaj_codigo) {
                    case 'SOLICITUD_INFORMACION':
                        $correo->subject = 'Consulta sobre el Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'RESPUESTA_INFORMACION':
                        $correo->subject = 'Respuesta del HLF a la consulta del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'DIAGNOSTICO_ESTIMACION':
                        $correo->subject = 'Diagnostico y estimación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'APROBACION_DIAGNOSTICO':
                        $correo->subject = 'Aprobación Diagnóstico del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'RECHAZO_DIAGNOSTICO':
                        $correo->subject = 'Rechazo Diagnóstico del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'VALIDACION_INDRA':
                        $correo->subject = 'Validación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'APROBACION_VALIDACION_INDRA':
                        $correo->subject = 'Aprobación de la validación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;
                    case 'RECHAZO_VALIDACION_HLF':
                        $correo->subject = 'Recahzo de la validación del Jira - '.$jira->jira_codigo;
                        $correo->titulo = $jira->jira_codigo;
                        $correo->cuerpo = $this->JiraCambioEstadoDestinario($jira, $TipoAccionJira, $User['name'], $UserJira->name);
                        $Estado = true;
                        break;                                        
                }
                if ($this->MailAccept && $Estado){
                    Mail::to($User['email'])->send($correo);
                }
            }
        }
        
        return true;

    }

    function EnvioCorreoVersion($vers_id, $veac_id, $tiaj_id){
        $version = Version::FindOrFail($vers_id);
        $VersionAccion = VersionAccion::FindOrFail($veac_id);
        $TipoAccionJira = TipoAccionJira::FindOrFail($tiaj_id);
        $UserVersion = User::FindOrFail($version->user_id);
        switch ($TipoAccionJira->tiaj_estado){
            case "Informativo":
                if ($TipoAccionJira->tiaj_codigo == 'CREACION_VERSION'){
                    $UsersInformativos = User::where('area', '=', 'Interno')->get();
                }
                else{
                    $UsersInformativos = User::all();
                }
                break; 
            case "Pregunta":
            case "Respuesta":
                $Users = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
                            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->select('users.id')
                            ->where('permissions.name', '=', 'create versionaccion')
                            ->get()
                            ->toArray();
                $UsersInformativos1 = User::select('users.id', 'users.name', 'users.email', 'users.area')
                            ->whereNotIn('users.id', $Users);

                $UsersInformativos2 = User::select('users.id', 'users.name', 'users.email', 'users.area')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
                            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->whereIn('users.id', $Users)
                            ->where('area', '=', $TipoAccionJira->tiaj_responsable_actual)
                            ->where('permissions.name', '=', 'create versionaccion');
                $UsersInformativos = $UsersInformativos1->union($UsersInformativos2)->get();
                $UsersDestinatario = User::select('users.id', 'users.name', 'users.email', 'users.area')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
                            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->whereIn('users.id', $Users)
                            ->distinct()
                            ->where('users.area', '=', $TipoAccionJira->tiaj_responsable_siguiente)
                            ->get();
                break;
        }
        
        if (isset($UsersInformativos) && $UsersInformativos->count() > 0){
            foreach ($UsersInformativos as $User){
                $Estado = false;
                $correo = new EnvioEstadosMailable();
                switch ($TipoAccionJira->tiaj_codigo) {
                    case 'CREACION_VERSION':
                        $correo->subject = 'Creación de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->CorreoCreacionVersion($version, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'ASIGNAR_JIRAS':
                        $correo->subject = 'Asignar jiras a la versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->CorreoAsignacionVersion($version, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'SOLICITUD_CIERRE':
                        $correo->subject = 'Solicitud de cierre de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'APROBACION_VERSION':
                        $correo->subject = 'Aprobación de Solicitud de cierre de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'RECHAZO_VERSION':
                        $correo->subject = 'Rechazo de Solicitud de cierre de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'CONSTRUCCION':
                        $correo->subject = 'Versión en construcción - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'ENTREGA_FABRICA':
                        $correo->subject = 'Versión ha sido entregada por fabrica - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'SOLICITUD_INSTALACION':
                        $correo->subject = 'Solicitud de instalación versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'APROBACION_INSTALACION':
                        $correo->subject = 'Aprobación de Instalación de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'INSTALACION_AMBIENTE':
                        $correo->subject = 'Se instala en preproductivo la versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'PRUEBAS_REGRESIVAS':
                        $correo->subject = 'Se finalizan las pruebas regresivas de la versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'PASO_PRODUCCION':
                        $correo->subject = 'Se instala en productivo la versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoInformativo($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                }
                if ($this->MailAccept && $Estado){
                    Mail::to($User['email'])->send($correo);
                }
            }
        }
        $User = '';
        if (isset($UsersDestinatario) && $UsersDestinatario->count() > 0){
            foreach ($UsersDestinatario as $User){
                $Estado = false;
                $correo = new EnvioEstadosMailable();
                switch ($TipoAccionJira->tiaj_codigo) {
                    case 'SOLICITUD_CIERRE':
                        $correo->subject = 'Solicitud de cierre de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoDestinario($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'APROBACION_VERSION':
                        $correo->subject = 'Aprobación de Solicitud de cierre de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoDestinario($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'RECHAZO_VERSION':
                        $correo->subject = 'Rechazo de Solicitud de cierre de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoDestinario($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'SOLICITUD_INSTALACION':
                        $correo->subject = 'Solicitud de instalación de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoDestinario($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                    case 'APROBACION_INSTALACION':
                        $correo->subject = 'Aprobación de Instalación de versión - '.$version->vers_nombre;
                        $correo->titulo = $version->vers_nombre;
                        $correo->cuerpo = $this->VersionCambioEstadoDestinario($version, $VersionAccion, $TipoAccionJira, $User['name'], $UserVersion->name);
                        $Estado = true;
                        break;
                }
                if ($this->MailAccept && $Estado){
                    Mail::to($User['email'])->send($correo);
                }
            }
        }
       
        return true;

    }

    function CorreoCreacionJira($jira, $name, $remitente){

        $cuerpo = Mensaje::where('mens_estado', 'CREACION_JIRA')->get()->first()->mens_email;
        $cuerpo = str_replace('{{ jira_codigo }}', $jira->jira_codigo, $cuerpo);
        $cuerpo = str_replace('{{ user_nombre }}', $name, $cuerpo);
        $Incidentes = Incidente::where('jira_id', $jira->jira_id)->get();
        $cuerpo = str_replace('{{ asunto }}', $jira->jira_asunto, $cuerpo);
        $cuerpo = str_replace('{{ descripcion }}', $jira->jira_descripcion, $cuerpo);
        $tickets = '';
        foreach ($Incidentes as $Incidente){
            $tickets .= '<li>'.$Incidente['inci_numero'].'</li>';
        }
        $cuerpo = str_replace('{{ tickets }}', $tickets, $cuerpo);
        $cuerpo = str_replace('{{ link }}', asset('/admin/jira/'.$jira->jira_id), $cuerpo);
        $cuerpo = str_replace('{{ remitente }}', $remitente, $cuerpo);
        return $cuerpo;
    }

    function JiraCambioEstadoDestinario($jira, $TipoAccionJira, $name, $remitente){
        $cuerpo = Mensaje::where('mens_estado', 'CAMBIO_JIRA_DESTINATARIO')->get()->first()->mens_email;
        $ResponsableActual = $TipoAccionJira->tiaj_nombre;
        $ResponsableSiguiente = ($TipoAccionJira->tiaj_responsable_siguiente == 'Interno') ? 'Indra' : 'HLF';
        $cuerpo = str_replace('{{ estado_actual }}', $ResponsableActual, $cuerpo);
        $cuerpo = str_replace('{{ responsable }}', $ResponsableSiguiente, $cuerpo);
        $cuerpo = str_replace('{{ jira_codigo }}', $jira->jira_codigo, $cuerpo);
        $cuerpo = str_replace('{{ user_nombre }}', $name, $cuerpo);
        $cuerpo = str_replace('{{ asunto }}', $jira->jira_asunto, $cuerpo);
        $cuerpo = str_replace('{{ descripcion }}', $jira->jira_descripcion, $cuerpo);
        $cuerpo = str_replace('{{ link }}', asset('/admin/jiraaccion/'.$jira->jira_id), $cuerpo);
        $cuerpo = str_replace('{{ remitente }}', $remitente, $cuerpo);
        return $cuerpo;
    }

    function JiraCambioEstadoInformativo($jira, $TipoAccionJira, $name, $remitente){
        $cuerpo = Mensaje::where('mens_estado', 'CAMBIO_JIRA_INFORMATIVO')->get()->first()->mens_email;
        $ResponsableActual = $TipoAccionJira->tiaj_nombre;
        $cuerpo = str_replace('{{ estado_actual }}', $ResponsableActual, $cuerpo);
        $cuerpo = str_replace('{{ jira_codigo }}', $jira->jira_codigo, $cuerpo);
        $cuerpo = str_replace('{{ user_nombre }}', $name, $cuerpo);
        $cuerpo = str_replace('{{ asunto }}', $jira->jira_asunto, $cuerpo);
        $cuerpo = str_replace('{{ descripcion }}', $jira->jira_descripcion, $cuerpo);
        $cuerpo = str_replace('{{ link }}', asset('/admin/jiraaccion/'.$jira->jira_id), $cuerpo);
        $cuerpo = str_replace('{{ remitente }}', $remitente, $cuerpo);
        return $cuerpo;
    }

    function CorreoCreacionVersion($Version, $name, $remitente){

        $cuerpo = Mensaje::where('mens_estado', 'CREACION_VERSION')->get()->first()->mens_email;
        $cuerpo = str_replace('{{ vers_nombre }}', $Version->vers_nombre, $cuerpo);
        $cuerpo = str_replace('{{ user_nombre }}', $name, $cuerpo);
        $TiposVersiones = TipoVersion::
                    join('versiones', 'tipos_versiones.vers_id', '=', 'versiones.vers_id')
                    ->join('tipo_jiras', 'tipo_jiras.tiji_id', '=', 'tipos_versiones.tiji_id')
                    ->where('versiones.vers_id', $Version->vers_id)->get();
        $tipos_versiones = '';
        foreach ($TiposVersiones as $TipoVersion){
            $tipos_versiones .= '<li>'.$TipoVersion['tiji_sistema'].'-'.$TipoVersion['tiji_nombre'].'</li>';
        }
        $cuerpo = str_replace('{{ tipo_version }}', $tipos_versiones, $cuerpo);
        $cuerpo = str_replace('{{ link }}', asset('/admin/version/'.$Version->vers_id), $cuerpo);
        $cuerpo = str_replace('{{ remitente }}', $remitente, $cuerpo);
        return $cuerpo;
    }    

    function CorreoAsignacionVersion($Version, $VersionAccion, $name, $remitente){

        $cuerpo = Mensaje::where('mens_estado', 'ASIGNAR_JIRAS')->get()->first()->mens_email;
        $cuerpo = str_replace('{{ vers_nombre }}', $Version->vers_nombre, $cuerpo);
        $cuerpo = str_replace('{{ user_nombre }}', $name, $cuerpo);
        $Jiras = Jira::where('jiras.vers_id', $Version->vers_id)->get();
        $CodigosJiras = '';
        foreach ($Jiras as $Jira){
            $CodigosJiras .= '<li>'.$Jira['jira_codigo'].'</li>';
        }
        $cuerpo = str_replace('{{ jiras }}', $CodigosJiras, $cuerpo);
        $cuerpo = str_replace('{{ link }}', asset('/admin/versionaccion/'.$Version->vers_id.'/'.$VersionAccion->veac_id), $cuerpo);
        $cuerpo = str_replace('{{ remitente }}', $remitente, $cuerpo);
        return $cuerpo;
    }    

    function VersionCambioEstadoDestinario($Version, $VersionAccion, $TipoAccionJira, $name, $remitente){
        $cuerpo = Mensaje::where('mens_estado', 'CAMBIO_VERSION_DESTINATARIO')->get()->first()->mens_email;
        $ResponsableActual = $TipoAccionJira->tiaj_nombre;
        $ResponsableSiguiente = ($TipoAccionJira->tiaj_responsable_siguiente == 'Interno') ? 'Indra' : 'HLF';
        $cuerpo = str_replace('{{ estado_actual }}', $ResponsableActual, $cuerpo);
        $cuerpo = str_replace('{{ responsable }}', $ResponsableSiguiente, $cuerpo);
        $cuerpo = str_replace('{{ vers_nombre }}', $Version->vers_nombre, $cuerpo);
        $cuerpo = str_replace('{{ user_nombre }}', $name, $cuerpo);
        $Jiras = Jira::where('jiras.vers_id', $Version->vers_id)->get();
        $CodigosJiras = '';
        foreach ($Jiras as $Jira){
            $CodigosJiras .= '<li>'.$Jira['jira_codigo'].'</li>';
        }
        $cuerpo = str_replace('{{ jiras }}', $CodigosJiras, $cuerpo);        
        $cuerpo = str_replace('{{ link }}', asset('/admin/versionaccion/'.$Version->vers_id.'/'.$VersionAccion->veac_id), $cuerpo);
        $cuerpo = str_replace('{{ remitente }}', $remitente, $cuerpo);
        return $cuerpo;
    }

    function VersionCambioEstadoInformativo($Version, $VersionAccion, $TipoAccionJira, $name, $remitente){
        $cuerpo = Mensaje::where('mens_estado', 'CAMBIO_VERSION_INFORMATIVO')->get()->first()->mens_email;
        $ResponsableActual = $TipoAccionJira->tiaj_nombre;
        $cuerpo = str_replace('{{ estado_actual }}', $ResponsableActual, $cuerpo);
        $cuerpo = str_replace('{{ vers_nombre }}', $Version->vers_nombre, $cuerpo);
        $cuerpo = str_replace('{{ user_nombre }}', $name, $cuerpo);
        $Jiras = Jira::where('jiras.vers_id', $Version->vers_id)->get();
        $CodigosJiras = '';
        foreach ($Jiras as $Jira){
            $CodigosJiras .= '<li>'.$Jira['jira_codigo'].'</li>';
        }
        $cuerpo = str_replace('{{ jiras }}', $CodigosJiras, $cuerpo);
        $cuerpo = str_replace('{{ link }}', asset('/admin/versionaccion/'.$Version->vers_id.'/'.$VersionAccion->veac_id), $cuerpo);
        $cuerpo = str_replace('{{ remitente }}', $remitente, $cuerpo);
        return $cuerpo;
    }

}

