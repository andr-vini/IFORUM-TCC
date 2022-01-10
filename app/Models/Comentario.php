<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['texto'];
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'matricula', 'matricula');
    }
    public function resposta()
    {
        return $this->belongsTo(Resposta::class);
    }
}
