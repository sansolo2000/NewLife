<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVersion extends Model
{
    protected $table = 'tipos_versiones';
    protected $primaryKey = 'tive_id';
    protected $fillable = ['vers_id', 'tiji_id'];
    public function __construct() {
        $this->connection = getConexionMysql();
    }
}


