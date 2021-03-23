<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoJira extends Model
{
    //
    protected $primaryKey = 'tiji_id';
    protected $fillable = ['tiji_nombre', 'tiji_indice', 'tiji_activo'];
    public function __construct() {
        $this->connection = getConexionMysql();
    }

    public static function CargarTiposJiras($clase = 'Boolean'){
        if ($clase == 'Boolean'){
            $valor = false;
        }
        if ($clase == 'String'){
            $valor = '';
        }
         
        $TiposJiras = (new static)::where('tiji_activo', true)->get()->toArray();
        foreach($TiposJiras as $TipoJira){
                $TipoJiraNew[$TipoJira['tiji_id']] = $valor;
        }
        return $TipoJiraNew;
    }
}
