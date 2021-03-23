<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoAccionesJirasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'Creación',
            'tiaj_indice'                   =>  10,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  '11|20',
            'tiaj_estado'                   =>  'Informativo',
            'tiaj_codigo'                   =>  'CREACION_JIRA'
        ]);

        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Consulta al HLF',
            'tiaj_indice'                   =>  11,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Externo',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  '12',
            'tiaj_estado'                   =>  'Pregunta',
            'tiaj_codigo'                   =>  'SOLICITUD_INFORMACION'
        ]);

        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'Respuesta del HLF',
            'tiaj_indice'                   =>  12,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Externo',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  '11|20',
            'tiaj_estado'                   =>  'Respuesta',
            'tiaj_codigo'                   =>  'RESPUESTA_INFORMACION'
        ]);

        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Diagnostico y estimación',
            'tiaj_indice'                   =>  20,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Externo',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  '30|31',
            'tiaj_estado'                   =>  'Pregunta',
            'tiaj_codigo'                   =>  'DIAGNOSTICO_ESTIMACION'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Aprobación Diagnóstico',
            'tiaj_indice'                   =>  30,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Externo',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  '40',
            'tiaj_estado'                   =>  'Respuesta',
            'tiaj_codigo'                   =>  'APROBACION_DIAGNOSTICO'            
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Rechazo Diagnóstico',
            'tiaj_indice'                   =>  31,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Externo',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  '11|20',
            'tiaj_estado'                   =>  'Respuesta',
            'tiaj_codigo'                   =>  'RECHAZO_DIAGNOSTICO'            
        ]);    
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Creación de Versión',
            'tiaj_indice'                   =>  40,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '41',
            'tiaj_estado'                   =>  'Informativo',
            'tiaj_codigo'                   =>  'CREACION_VERSION'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Asociar jiras a versión',
            'tiaj_indice'                   =>  41,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '42',
            'tiaj_estado'                   =>  'Informativo',
            'tiaj_codigo'                   =>  'ASIGNAR_JIRAS'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Solicitud de cierre de versión',
            'tiaj_indice'                   =>  42,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Externo',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '43|44',
            'tiaj_estado'                   =>  'Pregunta',
            'tiaj_codigo'                   =>  'SOLICITUD_CIERRE'

        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'Aprobación de Versión',
            'tiaj_indice'                   =>  43,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Externo',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '45',
            'tiaj_estado'                   =>  'Respuesta',
            'tiaj_codigo'                   =>  'APROBACION_VERSION'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'Rechazo de Versión',
            'tiaj_indice'                   =>  44,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Externo',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '42',
            'tiaj_estado'                   =>  'Respuesta',
            'tiaj_codigo'                   =>  'RECHAZO_VERSION'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'En construcción',
            'tiaj_indice'                   =>  45,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '46',
            'tiaj_estado'                   =>  'Informativo',
            'tiaj_codigo'                   =>  'CONSTRUCCION'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'Entrega de fabrica',
            'tiaj_indice'                   =>  46,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '47',
            'tiaj_estado'                   =>  'Informativo',
            'tiaj_codigo'                   =>  'ENTREGA_FABRICA'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Solicitud de instalación',
            'tiaj_indice'                   =>  47,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Externo',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '48',
            'tiaj_estado'                   =>  'Pregunta',
            'tiaj_codigo'                   =>  'SOLICITUD_INSTALACION'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'Aprobación de instalación',
            'tiaj_indice'                   =>  48,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Externo',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '49',
            'tiaj_estado'                   =>  'Respuesta',
            'tiaj_codigo'                   =>  'APROBACION_INSTALACION'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'Instalación en ambiente Preproductivo',
            'tiaj_indice'                   =>  49,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '50|60',
            'tiaj_estado'                   =>  'Informativo',
            'tiaj_codigo'                   =>  'INSTALACION_AMBIENTE'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Entrega de validación Indra',
            'tiaj_indice'                   =>  50,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Externo',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  '51|52',
            'tiaj_estado'                   =>  'Pregunta',
            'tiaj_codigo'                   =>  'VALIDACION_INDRA'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Aprobación Jira por HLF y entrega de evidencias',
            'tiaj_indice'                   =>  51,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Externo',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  null,
            'tiaj_estado'                   =>  'Respuesta',
            'tiaj_codigo'                   =>  'APROBACION_VALIDACION_INDRA'
        ]);        
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  1,
            'tiaj_nombre'                   =>  'Rechazo de Jira por HLF con evidencias',
            'tiaj_indice'                   =>  52,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Externo',
            'tiaj_responsable_siguiente'    =>  'Interno',
            'tiaj_tipo'                     =>  'Jira',
            'tiaj_sucesor'                  =>  '50',
            'tiaj_estado'                   =>  'Respuesta',
            'tiaj_codigo'                   =>  'RECHAZO_VALIDACION_HLF'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Entrega de pruebas regresivas',
            'tiaj_indice'                   =>  60,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  'Externo',
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  '61',
            'tiaj_estado'                   =>  'Informativo',
            'tiaj_codigo'                   =>  'PRUEBAS_REGRESIVAS'
        ]);
        DB::table('tipo_acciones_jiras')->insert([
            'ties_id'                       =>  4,
            'tiaj_nombre'                   =>  'Paso a producción',
            'tiaj_indice'                   =>  61,
            'tiaj_activo'                   =>  true,
            'tiaj_responsable_actual'       =>  'Interno',
            'tiaj_responsable_siguiente'    =>  null,
            'tiaj_tipo'                     =>  'Version',
            'tiaj_sucesor'                  =>  null,
            'tiaj_estado'                   =>  'Informativo',
            'tiaj_codigo'                   =>  'PASO_PRODUCCION'
        ]);
    }

}
