<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'idResposta';
    protected $fillable = ['texto', 'nota'];

    public function pergunta()
    {
        return $this->belongsTo(Pergunta::class);
    }
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idComentario');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'matricula', 'matricula');
    }
}
