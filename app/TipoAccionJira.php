<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoAccionJira extends Model
{
    protected $table = 'tipo_acciones_jiras';
    protected $primaryKey = 'tiaj_id';
    protected $fillable = ['ties_id', 'tiaj_nombre', 'tiaj_indice', 
                    'tiaj_activo', 'tiaj_responsable_actual', 'tiaj_responsable_siguiente', 
                    'tiaj_tipo', 'tiaj_sucesor', 'tiaj_estado', 'tiaj_codigo'];   

    public static function tiaj_codigo_id($codigo)
    {
        $id = DB::table('tipo_acciones_jiras')->where('tiaj_codigo', $codigo)->first()->tiaj_id;
        return $id;
    }   

    public function __construct() {
        $this->connection = getConexionMysql();
    }                    
}
