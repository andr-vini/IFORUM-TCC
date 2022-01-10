<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'idVinculo';
    protected $fillable = ['ativo', 'status'];
}
