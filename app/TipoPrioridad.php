<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPrioridad extends Model
{
    //
    protected $table = 'tipo_prioridades';
    protected $primaryKey = 'tipr_id';
    protected $fillable = ['tipr_nombre', 'tipr_indice', 'tipr_activo'];
    public function __construct() {
        $this->connection = getConexionMysql();
    }
}
