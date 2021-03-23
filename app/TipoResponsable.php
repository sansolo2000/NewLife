<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoResponsable extends Model
{
    //
    protected $primaryKey = 'tire_id';
    protected $fillable = ['tire_nombre', 'tire_indice', 'tire_activo', 'tire_area', 'tire_asignable'];
    public function __construct() {
        $this->connection = getConexionMysql();
    }
}
