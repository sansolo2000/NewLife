<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VersionAccion extends Model
{
    protected $table = 'versiones_acciones';
    protected $primaryKey = 'veac_id';
    protected $fillable = ['vers_id', 'tiaj_id', 'veac_nombre', 'veac_evidencia', 'veac_fecha', 'veac_activo', 'user_id'];

    public function veac_nombre_limite()
    {
        return Str::limit($this->veac_nombre, 50);
    }    


    public function veac_fecha_format()
    {
        return Carbon::parse($this->veac_fecha)->format('d-m-Y');
    }

    public function __construct() {
        $this->connection = getConexionMysql();
    }
}
