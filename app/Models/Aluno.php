<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['moderador'];
    protected $primaryKey = 'idAluno';

    public function usuario()
    {
        return $this->morphOne(Usuario::class, 'tipo');
    }
    public function saladeaulas()
    {
        return $this->belongsToMany(SalaDeAula::class, 'vinculos', 'idAluno', 'idSalaDeAula');
    }
}
