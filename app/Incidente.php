<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Incidente extends Model
{
    protected $primaryKey = 'inci_id';
    protected $fillable = ['jira_id', 'inci_numero', 'inci_asunto', 
                            'inci_descripcion', 'inci_tecnico', 
                            'inci_fecha'];

    public function inci_fecha_format()
    {
        return Carbon::parse($this->inci_fecha)->format('d-m-Y');
    }
    public function inci_descripcion_limite()
    {
        return Str::limit($this->inci_descripcion, 300);
    }

    public function ObtenerIncidentes($jira){
        
        $incidentes = WorkOrder::where('workorder_fields.udf_char6', '=', $jira->jira_codigo)
                ->leftjoin('workordertodescription', 'workorder.workorderid', '=', 'workordertodescription.workorderid')
                ->leftjoin('workorderstates', 'workorder.workorderid', '=', 'workorderstates.workorderid')
                ->leftjoin('sduser', 'workorderstates.ownerid', '=', 'sduser.userid')
                ->leftjoin('aaauser', 'sduser.userid', '=', 'aaauser.user_id')
                ->leftjoin('technician', 'sduser.ciid', '=', 'technician.ciid')
                ->leftjoin('workorder_fields', 'workorder.workorderid', '=', 'workorder_fields.workorderid');

        $incidentesNew = $incidentes->select('workorder.workorderid as inci_numero')
                ->get()->toArray();

        $incidentesOld = Incidente::where('incidentes.jira_id', $jira->jira_id)
                ->select('inci_numero')->get()->toArray();

        foreach($incidentesNew as $New){
            $incidenteNew[] = $New['inci_numero'];
        }
        foreach($incidentesOld as $Old){
            $incidenteOld[] = $Old['inci_numero'];
        }
        
        $incidentes = $incidentes->select('workorder.workorderid as inci_numero', 
                            'aaauser.first_name as inci_tecnico', 
                            'workorder.title as inci_asunto',
                            'workordertodescription.fulldescription as inci_descripcion', 
                            DB::raw("to_char(from_unixtime(workorder.createdtime/1000),'DD/MM/YYYY') as inci_fecha"))
                ->get();
        if (isset($incidenteOld, $incidenteNew)){
            $Eliminars = array_diff($incidenteOld, $incidenteNew);
            foreach($Eliminars as $Eliminar){
                $IncidenteDel = Incidente::where('inci_numero', $Eliminar);
                $IncidenteDel->delete();
            }
        }

        foreach($incidentes as $incidente){   
            $IncidenteNew = Incidente::firstOrCreate(
                ['inci_numero' => $incidente['inci_numero']],
                ['jira_id' => $jira->jira_id, 'inci_asunto' => $incidente['inci_asunto'],
                'inci_descripcion' => $incidente['inci_descripcion'], 
                'inci_tecnico' => $incidente['inci_tecnico'],
                'inci_fecha' => Carbon::createFromFormat('d/m/Y', $incidente['inci_fecha'])]);
        }        
        
        return Incidente::where('jiras.jira_id', $jira->jira_id)
        ->join('jiras', 'incidentes.jira_id', '=',  'jiras.jira_id')
        ->select('incidentes.inci_numero', 'incidentes.inci_asunto', 'incidentes.inci_descripcion', 'incidentes.inci_tecnico', 'incidentes.inci_fecha')
        ->get();
    }

}
