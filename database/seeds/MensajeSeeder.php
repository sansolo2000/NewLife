<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MensajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mensajes')->insert([
            'mens_email'    =>  $this->creacion(),
            'mens_estado'   => 'CREACION_JIRA'
        ]);
        DB::table('mensajes')->insert([
            'mens_email'    =>  $this->JiraCambioEstadoDestinario(),
            'mens_estado'   => 'CAMBIO_JIRA_DESTINATARIO'
        ]);
        DB::table('mensajes')->insert([
            'mens_email'    =>  $this->JiraCambioEstadoInformativo(),
            'mens_estado'   => 'CAMBIO_JIRA_INFORMATIVO'
        ]);
        DB::table('mensajes')->insert([
            'mens_email'    =>  $this->CreacionVersion(),
            'mens_estado'   => 'CREACION_VERSION'
        ]);
        DB::table('mensajes')->insert([
            'mens_email'    =>  $this->AsignarJiras(),
            'mens_estado'   => 'ASIGNAR_JIRAS'
        ]);
        DB::table('mensajes')->insert([
            'mens_email'    =>  $this->VersionCambioEstadoDestinario(),
            'mens_estado'   => 'CAMBIO_VERSION_DESTINATARIO'
        ]);
        DB::table('mensajes')->insert([
            'mens_email'    =>  $this->VersionJiraCambioEstadoInformativo(),
            'mens_estado'   => 'CAMBIO_VERSION_INFORMATIVO'
        ]);        
    }

    public function creacion(){
        return '<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->

                            <div style="line-height: 35px">

                                Se ha creado un nuevo jira <span style="color: #5caad2;">{{ jira_codigo }}</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->

                                        <p style="line-height: 24px; margin-bottom:15px;">

                                            Estimad@ {{ user_nombre }},

                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                            Se ha creado un nuevo Jira con el siguiente asunto:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											{{ asunto }}
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                            y descripción:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											{{ descripcion }}
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
										Las incidencias de services desk asociadas al jira son las siguientes:
                                        </p>
										<ul>
											{{ tickets }}
										</ul>
                                        <p style="line-height: 24px; margin-bottom:20px;">
                                            Usted puede revisar la información en el siguiente link:
                                        </p>

                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->

                                                    <div style="line-height: 22px;">
                                                        <a href="{{ link }}" style="color: #ffffff; text-decoration: none;">{{ jira_codigo }}</a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>

                                        </table>
                                        <p style="line-height: 24px">
                                            Atentamente,</br>
                                            {{ remitente }}
                                        </p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
        </tr>
    </table>';
    }
    public function JiraCambioEstadoDestinario(){
        return '<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->

                            <div style="line-height: 35px">

                                Cambio de estado del Jira: <span style="color: #5caad2;">{{ jira_codigo }}</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->

                                        <p style="line-height: 24px; margin-bottom:15px;">

                                            Estimad@ {{ user_nombre }},

                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                            El Jira {{ jira_codigo }} ha cambiado al estado <span style="color: #5caad2;">"{{ estado_actual }}"</span> y requiere atención usted o alguien del equipo de {{ responsable }}.  El asunto del Jira es:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											{{ asunto }}
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                            Detalle:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											{{ descripcion }}
                                        </p>
                                        <p style="line-height: 24px; margin-bottom:20px;">
                                            Usted puede revisar la información en el siguiente link:
                                        </p>

                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->

                                                    <div style="line-height: 22px;">
                                                        <a href="{{ link }}" style="color: #ffffff; text-decoration: none;">{{ jira_codigo }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <p style="line-height: 24px">
                                            Atentamente,</br>
                                            {{ remitente }}
                                        </p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
        </tr>
    </table>';
    }
    function JiraCambioEstadoInformativo(){
        return '<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->

                            <div style="line-height: 35px">

                                Cambio de estado del Jira: <span style="color: #5caad2;">{{ jira_codigo }}</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->

                                        <p style="line-height: 24px; margin-bottom:15px;">

                                            Estimad@ {{ user_nombre }},

                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                            El Jira {{ jira_codigo }} ha cambiado de estado a <span style="color: #5caad2;">"{{ estado_actual }}"</span>.  El asunto del Jira es:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											{{ asunto }}
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                            Detalle:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											{{ descripcion }}
                                        </p>
                                        <p style="line-height: 24px; margin-bottom:20px;">
                                            Usted puede revisar la información en el siguiente link:
                                        </p>

                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->

                                                    <div style="line-height: 22px;">
                                                        <a href="{{ link }}" style="color: #ffffff; text-decoration: none;">{{ jira_codigo }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <p style="line-height: 24px">
                                            Atentamente,</br>
                                            {{ remitente }}
                                        </p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
        </tr>
    </table>';
    }
    function CreacionVersion(){
        return '<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->
                            <div style="line-height: 35px">
                                Nueva versión o paquete de soluciones - <span style="color: #5caad2;">{{ vers_nombre }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->
                                        <p style="line-height: 24px; margin-bottom:15px;">
                                            Estimad@ {{ user_nombre }},
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											Se ha creado una nueva Versión o paquete de soluciones, su nombre es <span style="color: #5caad2;">{{ vers_nombre }}</span> con los siguientes tipos de versión:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											<ul>
												{{ tipo_version }}
											</ul>
                                        </p>
                                        <p style="line-height: 24px; margin-bottom:20px;">
                                            Usted puede revisar la información en el siguiente link:
                                        </p>
                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->

                                                    <div style="line-height: 22px;">
                                                        <a href="{{ link }}" style="color: #ffffff; text-decoration: none;">{{ vers_nombre }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <p style="line-height: 24px">
                                            Atentamente,</br>
                                            {{ remitente }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
        </tr>
    </table>';
    }

    function AsignarJiras(){
        return '<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->
                            <div style="line-height: 35px">
                                Asignación de jiras a la versión o paquete de soluciones <span style="color: #5caad2;">{{ vers_nombre }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->
                                        <p style="line-height: 24px; margin-bottom:15px;">
                                            Estimad@ {{ user_nombre }},
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											Se han asignado los jiras a la versión o paquete de soluciones <span style="color: #5caad2;">{{ vers_nombre }}</span>.  Los jiras asignados a esta versión son los siguientes:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											<ul>
												{{ jiras }}
											</ul>
                                        </p>
                                        <p style="line-height: 24px; margin-bottom:20px;">
                                            Usted puede revisar la información en el siguiente link:
                                        </p>
                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->

                                                    <div style="line-height: 22px;">
                                                        <a href="{{ link }}" style="color: #ffffff; text-decoration: none;">{{ vers_nombre }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <p style="line-height: 24px">
                                            Atentamente,</br>
                                            {{ remitente }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
        </tr>
    </table>';
    }
    function VersionCambioEstadoDestinario(){
        return '    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->

                            <div style="line-height: 35px">

                                Cambio de estado de la Versión: <span style="color: #5caad2;">{{ vers_nombre }}</span>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->

                                        <p style="line-height: 24px; margin-bottom:15px;">

                                            Estimad@ {{ user_nombre }},

                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                            La versión {{ vers_nombre }} ha cambiado de estado a <span style="color: #5caad2;">"{{ estado_actual }}"</span> y requiere atención usted o alguien del equipo de {{ responsable }}.  Los Jiras asociados son los siguientes:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											<ul>
												{{ jiras }}
											</ul>
                                        </p>
                                        <p style="line-height: 24px; margin-bottom:20px;">
                                            Usted puede revisar la información en el siguiente link:
                                        </p>

                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->

                                                    <div style="line-height: 22px;">
                                                        <a href="{{ link }}" style="color: #ffffff; text-decoration: none;">{{ vers_nombre }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <p style="line-height: 24px">
                                            Atentamente,</br>
                                            {{ remitente }}
                                        </p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
        </tr>
    </table>';
    }
    function VersionJiraCambioEstadoInformativo(){
        return '<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->
                            <div style="line-height: 35px">
                                Cambio de estado de la Versión: <span style="color: #5caad2;">{{ vers_nombre }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->
                                        <p style="line-height: 24px; margin-bottom:15px;">
                                            Estimad@ {{ user_nombre }},
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                            La Versión {{ vers_nombre }} ha cambiado de estado a <span style="color: #5caad2;">"{{ estado_actual }}"</span>.  Los Jiras asociados son los siguientes:
                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
											<ul>
												{{ jiras }}
											</ul>
                                        </p>
                                        <p style="line-height: 24px; margin-bottom:20px;">
                                            Usted puede revisar la información en el siguiente link:
                                        </p>
                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->
                                                    <div style="line-height: 22px;">
                                                        <a href="{{ link }}" style="color: #ffffff; text-decoration: none;">{{ vers_nombre }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <p style="line-height: 24px">
                                            Atentamente,</br>
                                            {{ remitente }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
        </tr>
    </table>';
    }
}