<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TipoEstado extends Model
{
    //
    protected $primaryKey = 'ties_id';
    protected $fillable = ['ties_nombre', 'ties_indice', 'ties_activo'];
    public function __construct() {
        $this->connection = getConexionMysql();
    }

}

