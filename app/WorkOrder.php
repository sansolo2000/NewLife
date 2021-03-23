<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'workorder';
    protected $primaryKey = 'workorderid';
    protected $fillable = ['title'];

    public function __construct() {
        $this->connection = getConexionPgsql();
    }
}
