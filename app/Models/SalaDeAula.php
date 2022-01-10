<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaDeAula extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['nome', 'ano', 'periodo', 'idDiario'];
    protected $primaryKey = 'idSalaDeAula';
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'vinculos', 'idSalaDeAula', 'idAluno');
    }
    public function pergunta()
    {
        return $this->hasMany(Pergunta::class, 'idSalaDeAula');
    }
}
