<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['email'];
    protected $primaryKey = 'idProfessor';

    public function usuario()
    {
        return $this->morphOne(Usuario::class, 'tipo');
    }
    public function saladeaulas()
    {
        return $this->hasMany(SalaDeAula::class, 'idProfessor');
    }
}
