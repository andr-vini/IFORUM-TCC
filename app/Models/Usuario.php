<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'matricula';
    protected $fillable = ['apelido'];

    public function tipo()
    {
        return $this->morphTo();
    }
    public function perguntas()
    {
        return $this->hasMany(Pergunta::class);
    }
    public function likes()
    {
        return $this->belongsToMany(Pergunta::class, 'likes', 'matricula', 'idPergunta');
    }
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
    public function respostas()
    {
        return $this->hasMany(Resposta::class);
    }
}
