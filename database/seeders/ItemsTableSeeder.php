<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon1.png',
                'categoria' => 1,
                'nome' => 'icone1',
                'preco' => 10
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon2.png',
                'categoria' => 1,
                'nome' => 'icone2',
                'preco' => 15
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon3.png',
                'categoria' => 1,
                'nome' => 'icone3',
                'preco' => 20
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon4.png',
                'categoria' => 1,
                'nome' => 'icone4',
                'preco' => 25
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon5.png',
                'categoria' => 1,
                'nome' => 'icone5',
                'preco' => 30
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon6.png',
                'categoria' => 1,
                'nome' => 'icone6',
                'preco' => 35
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon7.png',
                'categoria' => 1,
                'nome' => 'icone7',
                'preco' => 40
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon8.png',
                'categoria' => 1,
                'nome' => 'icone8',
                'preco' => 45
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon9.png',
                'categoria' => 1,
                'nome' => 'icone9',
                'preco' => 50
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/items/icon10.png',
                'categoria' => 1,
                'nome' => 'icone10',
                'preco' => 55
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/medalhas/medalhaVermelha.png',
                'categoria' => 2,
                'nome' => 'Medalha Vermelha',
                'preco' => 20
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/medalhas/medalhaAzul.png',
                'categoria' => 2,
                'nome' => 'Medalha Azul',
                'preco' => 40
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/medalhas/medalhaVerde.png',
                'categoria' => 2,
                'nome' => 'Medalha Verde',
                'preco' => 60
            ]);
        DB::table('items')->insert(            
            [
                'caminho' => '/img/medalhas/medalhaAmarela.png',
                'categoria' => 2,
                'nome' => 'Medalha Amarela',
                'preco' => 80
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/medalhas/medalhaRosa.png',
                'categoria' => 2,
                'nome' => 'Medalha Rosa',
                'preco' => 100
            ]);
        DB::table('items')->insert(
            [
                'caminho' => '/img/medalhas/medalhaRoxa.png',
                'categoria' => 2,
                'nome' => 'Medalha Roxa',
                'preco' => 120
            ]
        );
    }
}
