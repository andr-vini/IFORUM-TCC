<?php

namespace App\Http\Controllers;

use App\Models\Aluno;

class RankingController extends Controller
{
    public function getRanking()
    {
        PerfilController::getPontuacao();
        $alunos = Aluno::all()->sortByDesc('pontuacao')->take(10);
        return view('ranking')->with('alunos', $alunos);
    }
}
