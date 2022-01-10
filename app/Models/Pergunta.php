<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'idPergunta';
    protected $fillable = ['texto', 'status', 'nota'];
    public function saladeaula()
    {
        return $this->belongsTo(SalaDeAula::class);
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'matricula', 'matricula');
    }
    public function likes()
    {
        return $this->belongsToMany(Usuario::class, 'likes', 'idPergunta', 'matricula');
    }
    public function respostas()
    {
        return $this->hasMany(Resposta::class, 'idPergunta');
    }
}
