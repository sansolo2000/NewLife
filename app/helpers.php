<?php

use Illuminate\Support\Facades\DB;
use App\WorkOrder;

if (! function_exists('print_f')) {
    function print_f($array, $exit = true, $table = false)
    {
        echo '<pre style="border:1px solid red;">';
        if ($table){
            echo '<table>';
            echo '<tr>';
            echo '<td>';
        }
        print_r(str_replace ('`', '', $array));
        if ($table){
            echo '</td>';
            echo '</tr>';
            echo '</table>';
        }
        echo '</pre>';
        if ($exit){
            exit;
        }
    }
}


if (! function_exists('quitar_tildes')) {
        function quitar_tildes ($cadena)
    {
        $cadBuscar = array("á", "Á", "é", "É", "í", "Í", "ó", "Ó", "ú", "Ú", "Ñ", "ñ", ".", " ");
        $cadPoner =  array("a", "A", "e", "E", "i", "I", "o", "O", "u", "U", "N", "n", "_", "_");
        $cadena = str_replace ($cadBuscar, $cadPoner, $cadena);
        return $cadena;
    }
}

if (! function_exists('getConexionMysql')) {
    function getConexionMysql(){
        return "mysql";
    }
}

if (! function_exists('getConexionPgsql')) {
    function getConexionPgsql(){
        return "pgsql";
    }
}

if (! function_exists('ObtenerServiceDesk')) {
    function ObtenerServiceDesk($id){


        $invoices = WorkOrder::where('workorder_fields.udf_char6', '=', $id)
                ->leftjoin('workordertodescription', 'workorder.workorderid', '=', 'workordertodescription.workorderid')
                ->leftjoin('workorderstates', 'workorder.workorderid', '=', 'workorderstates.workorderid')
                ->leftjoin('sduser', 'workorderstates.ownerid', '=', 'sduser.userid')
                ->leftjoin('aaauser', 'sduser.userid', '=', 'aaauser.user_id')
                ->leftjoin('technician', 'sduser.ciid', '=', 'technician.ciid')
                ->leftjoin('workorder_fields', 'workorder.workorderid', '=', 'workorder_fields.workorderid')
                ->select('workorder.workorderid as ticket', 'aaauser.first_name as tecnico', 'workorder.title as asunto',
                'workordertodescription.fulldescription as descripcion', 'workorder_fields.udf_char6 as jira',
                'workorder_fields.udf_char11 as funcional', 'workorder_fields.udf_char9 as estado_jira',
                'technician.attribute_301 as estadojira',
                'workorder_fields.udf_char10 as ambiente', 'workorder_fields.udf_char8 as version_correctivo')
                ->get();
        return $invoices;
    }
}

if (! function_exists('TipoVersionChecked')) {
    function TipoVersionChecked($TipoVersionOld, $TipoVersionNew){
        if (!is_null($TipoVersionOld)){
            $TipoVersion = array('checked' => 'checked');
        }
        else{
            if(!is_null($TipoVersionNew)){
                $TipoVersion = array('checked' => 'checked');
            }
            else{
                $TipoVersion = null;
            }
            
        } 
        return $TipoVersion;
    }
}


if (! function_exists('codigos_jiras')) {
    function codigos_jiras(){
        $codigos = array('MSOHLFF-449',
        'MSOHLFF-471',
        'MSOHLFF-1074',
        'MSOHLFF-413',
        'HLFSSS-161',
        'MSOHLFF-364',
        'MSOHLFF-1135',
        'MSOHLFF-620',
        'MSOHLFF-707',
        'HLFSSS-173',
        'MSOHLFF-329',
        'HLFSSS-191',
        'HLFSSS-253',
        'HLFSSS-254',
        'MSOHLFF-445',
        'MSOHLFF-428',
        'MSOHLFF-388',
        'MSOHLFF-1048',
        'MSOHLFF-423',
        'MSOHLFF-251',
        'MSOHLFF-548',
        'MSOHLFF-274',
        'MSOHLFF-1099',
        'MSOHLFF-422',
        'MSOHLFF-847',
        'MSOHLFF-176',
        'MSOHLFF-179',
        'HLFSSS-181',
        'MSOHLFF-400',
        'HLFSSS-211',
        'MSOHLFF-952',
        'MSOHLFF-467',
        'HLFSSS-233',
        'MSOHLFF-772',
        'MSOHLFF-874',
        'HLFSSS-240',
        'MSOHLFF-1041',
        'HLFSSS-199',
        'MSOHLFF-360',
        'MSOHLFF-1100',
        'MSOHLFF-508',
        'MSOHLFF-1158',
        'HLFSSS-267',
        'MSOHLFF-482',
        'MSOHLFF-1017',
        'HLFSSS-228',
        'MSOHLFF-853',
        'MSOHLFF-466',
        'MSOHLFF-230',
        'MSOHLFF-549',
        'MSOHLFF-857',
        'MSOHLFF-1039',
        'MSOHLFF-1047',
        'MSOHLFF-618',
        'MSOHLFF-284',
        'MSOHLFF-419',
        'HLFSSS-172',
        'MSOHLFF-244',
        'HLFSSS-258',
        'MSOHLFF-1119',
        'MSOHLFF-332',
        'MSOHLFF-204',
        'HLFSSS-214',
        'MSOHLFF-6',
        'HLFSSS-265',
        'MSOHLFF-442',
        'MSOHLFF-385',
        'HLFSSS-251',
        'MSOHLFF-728',
        'MSOHLFF-617',
        'MSOHLFF-22',
        'HLFSSS-263',
        'MSOHLFF-514',
        'MSOHLFF-269',
        'MSOHLFF-739',
        'MSOHLFF-346',
        'MSOHLFF-657',
        'MSOHLFF-229',
        'HLFSSS-187',
        'HLFSSS-236',
        'MSOHLFF-350',
        'MSOHLFF-1108',
        'MSOHLFF-1071',
        'MSOHLFF-809',
        'MSOHLFF-1142',
        'MSOHLFF-724',
        'HLFSSS-209',
        'MSOHLFF-602',
        'HLFSSS-168',
        'MSOHLFF-580',
        'MSOHLFF-633',
        'HLFSSS-203',
        'HLFSSS-245',
        'MSOHLFF-156',
        'MSOHLFF-604',
        'MSOHLFF-905',
        'MSOHLFF-468',
        'MSOHLFF-1156',
        'MSOHLFF-353',
        'MSOHLFF-612',
        'HLFSSS-250',
        'MSOHLFF-770',
        'MSOHLFF-240',
        'MSOHLFF-469',
        'MSOHLFF-505',
        'MSOHLFF-872',
        'MSOHLFF-412',
        'HLFSSS-224',
        'HLFSSS-158',
        'MSOHLFF-355',
        'HLFSSS-229',
        'HLFSSS-238',
        'MSOHLFF-157',
        'HLFSSS-210',
        'MSOHLFF-340',
        'MSOHLFF-213',
        'HLFSSS-196',
        'MSOHLFF-411',
        'HLFSSS-227',
        'MSOHLFF-848',
        'MSOHLFF-1138',
        'HLFSSS-156',
        'HLFSSS-219',
        'HLFSSS-170',
        'MSOHLFF-582',
        'MSOHLFF-261',
        'MSOHLFF-410',
        'MSOHLFF-522',
        'MSOHLFF-527',
        'HLFSSS-230',
        'MSOHLFF-1133',
        'MSOHLFF-429',
        'HLFSSS-220',
        'HLFSSS-266',
        'MSOHLFF-215',
        'HLFSSS-248',
        'MSOHLFF-599',
        'HLFSSS-235',
        'HLFSSS-256',
        'MSOHLFF-1011',
        'MSOHLFF-286',
        'MSOHLFF-926',
        'MSOHLFF-1093',
        'MSOHLFF-601',
        'MSOHLFF-706',
        'HLFSSS-169',
        'HLFSSS-157',
        'MSOHLFF-1062',
        'MSOHLFF-605',
        'MSOHLFF-181',
        'MSOHLFF-499',
        'HLFSSS-212',
        'HLFSSS-244',
        'HLFSSS-193',
        'HLFSSS-165',
        'MSOHLFF-249',
        'MSOHLFF-831',
        'MSOHLFF-832',
        'HLFSSS-192',
        'MSOHLFF-565',
        'HLFSSS-164',
        'MSOHLFF-382',
        'MSOHLFF-1069',
        'MSOHLFF-1144',
        'HLFSSS-213',
        'MSOHLFF-632',
        'HLFSSS-262',
        'MSOHLFF-1095',
        'HLFSSS-174',
        'HLFSSS-234',
        'MSOHLFF-1038',
        'MSOHLFF-224',
        'MSOHLFF-821',
        'HLFSSS-185',
        'MSOHLFF-515',
        'MSOHLFF-570',
        'HLFSSS-239',
        'MSOHLFF-906',
        'HLFSSS-223',
        'HLFSSS-202',
        'MSOHLFF-218',
        'MSOHLFF-402',
        'MSOHLFF-720',
        'MSOHLFF-578',
        'HLFSSS-260',
        'HLFSSS-171',
        'MSOHLFF-603',
        'MSOHLFF-1029',
        'MSOHLFF-856',
        'HLFSSS-177',
        'MSOHLFF-987',
        'HLFSSS-159',
        'MSOHLFF-1115',
        'MSOHLFF-558',
        'MSOHLFF-1114',
        'HLFSSS-255',
        'HLFSSS-166',
        'HLFSSS-175',
        'MSOHLFF-336',
        'MSOHLFF-497',
        'MSOHLFF-1098',
        'HLFSSS-160',
        'HLFSSS-176',
        'MSOHLFF-737',
        'MSOHLFF-802',
        'MSOHLFF-958',
        'MSOHLFF-354',
        'MSOHLFF-526',
        'HLFSSS-257',
        'MSOHLFF-1023',
        'HLFSSS-155',
        'HLFSSS-237',
        'MSOHLFF-528',
        'HLFSSS-242',
        'MSOHLFF-520',
        'MSOHLFF-333',
        'HLFSSS-188',
        'MSOHLFF-448',
        'MSOHLFF-534',
        'MSOHLFF-810',
        'MSOHLFF-465',
        'MSOHLFF-948',
        'MSOHLFF-600',
        'MSOHLFF-608',
        'MSOHLFF-177',
        'MSOHLFF-533',
        'HLFSSS-216',
        'HLFSSS-243',
        'MSOHLFF-631',
        'MSOHLFF-1036',
        'MSOHLFF-531',
        'MSOHLFF-352',
        'MSOHLFF-391',
        'HLFSSS-259',
        'MSOHLFF-546',
        'MSOHLFF-323',
        'MSOHLFF-1104',
        'MSOHLFF-1145',
        'MSOHLFF-175',
        'MSOHLFF-484',
        'MSOHLFF-543',
        'MSOHLFF-871',
        'MSOHLFF-345',
        'HLFSSS-200',
        'HLFSSS-264',
        'MSOHLFF-285',
        'HLFSSS-186',
        'MSOHLFF-820',
        'MSOHLFF-516',
        'MSOHLFF-1096',
        'MSOHLFF-483',
        'HLFSSS-252',
        'HLFSSS-249',
        'HLFSSS-207',
        'HLFSSS-232',
        'MSOHLFF-732',
        'HLFSSS-163',
        'HLFSSS-226',
        'MSOHLFF-1123',
        'MSOHLFF-178',
        'MSOHLFF-324',
        'HLFSSS-268',
        'HLFSSS-178',
        'MSOHLFF-95',
        'MSOHLFF-597',
        'MSOHLFF-331',
        'MSOHLFF-865',
        'MSOHLFF-615',
        'MSOHLFF-1136',
        'MSOHLFF-854',
        'MSOHLFF-613',
        'MSOHLFF-771',
        'MSOHLFF-183',
        'HLFSSS-208',
        'HLFSSS-261',
        'HLFSSS-247',
        'MSOHLFF-1166',
        'MSOHLFF-1118',
        'HLFSSS-195',
        'HLFSSS-241',
        'MSOHLFF-943',
        'MSOHLFF-188',
        'MSOHLFF-833',
        'HLFSSS-246',
        'MSOHLFF-430',
        'HLFSSS-221',
        'HDLFIHH-19089');
        return $codigos;
    }
}