<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\TipoEstado;

class Jira extends Model
{
    protected $primaryKey = 'jira_id';
    protected $fillable = ['tire_id', 'ties_id', 'tipr_id', 'tiji_id',
                            'vers_id', 'user_id', 'jira_codigo', 'jira_asunto',
                            'jira_descripcion', 'jira_fecha', 'user_id'];

    public function jira_fecha_format()
    {
        return Carbon::parse($this->jira_fecha)->format('d-m-Y');
    }
    public function jira_descripcion_limite()
    {
        return Str::limit($this->jira_descripcion, 50);
    }
    public function jiac_fecha_format()
    {
        return Carbon::parse($this->jiac_fecha)->format('d-m-Y');
    }
    public function ties_id_cambio($tiaj_id, $nueva){


        $TipoAccionJira = TipoAccionJira::select('tipo_acciones_jiras.tiaj_id', 
                            'tipo_acciones_jiras.ties_id')
                    ->where('tipo_acciones_jiras.tiaj_id', '<=', $tiaj_id)
                    ->orderBy('tipo_acciones_jiras.tiaj_indice', 'desc')
                    ->get()->toArray(); 

        if ($nueva){
            return $TipoAccionJira[0]['ties_id'];
        }
        else {
            return $TipoAccionJira[1]['ties_id'];
        }
    }

    public static function SearchCodigoActivo($codigo){
        $JiraSearch = (new static)::where('jira_codigo', $codigo)->count();
        if ($JiraSearch > 0) {
            return true;
        }
        else{
            return false;
        }
    }
}
