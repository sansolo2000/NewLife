<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class JiraAccion extends Model
{
    //
    protected $table = 'jiras_acciones';
    protected $primaryKey = 'jiac_id';
    protected $fillable = ['jira_id', 'tiaj_id', 'jiac_descripcion', 'jiac_observacion',
                        'jiac_fecha', 'user_id', 'jiac_ruta','jiac_activo'];


    public function jiac_fecha_format()
    {
        return Carbon::parse($this->jiac_fecha)->format('d-m-Y');
    }
    public function jiac_descripcion_limite()
    {
        return Str::limit($this->jiac_descripcion, 50);
    } 

    public function __construct() {
        $this->connection = getConexionMysql();
    }
}                        
