<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class NotaJira extends Model
{
    protected $table = 'notas_jiras';
    protected $primaryKey = 'noji_id';
    protected $fillable = ['jira_id', 'user_id', 'noji_padre', 'noji_asunto', 'noji_descripcion', 'noji_fecha', 'noji_ruta'];

    public function noji_fecha_format()
    {
        return Carbon::parse($this->noji_fecha)->format('d-m-Y H:i');
    }
    
}
