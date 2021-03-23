<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensajes';
    protected $primaryKey = 'jiac_id';
    protected $fillable = ['mens_id', 'tiaj_id', 'mens_email'];


}
