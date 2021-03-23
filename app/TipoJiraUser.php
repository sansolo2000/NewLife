<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoJiraUser extends Model
{
    //
    protected $table = 'tipo_jiras_users';
    protected $primaryKey = 'tjus_id';
    protected $fillable = ['tiji_id', 'user_is'];

    public function __construct() {
        $this->connection = getConexionMysql();
    }
}
