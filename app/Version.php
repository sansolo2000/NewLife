<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Version extends Model
{
    protected $table = 'versiones';
    protected $primaryKey = 'vers_id';
    protected $fillable = ['vers_nombre', 'vers_activo', 'vers_fecha_creacion'];

    public function vers_fecha_creacion_format()
    {
        return Carbon::parse($this->vers_fecha_creacion)->format('d-m-Y');
    }
    
    public function veac_fecha_format()
    {
        return Carbon::parse($this->veac_fecha)->format('d-m-Y');
    }

    public function __construct() {
        $this->connection = getConexionMysql();
    }

}
