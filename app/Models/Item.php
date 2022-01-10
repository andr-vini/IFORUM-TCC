<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'idItem';
    protected $fillable = ['preco', 'categoria', 'caminho'];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class);
    }
}
