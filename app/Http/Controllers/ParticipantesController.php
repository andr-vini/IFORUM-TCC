<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Vinculo;

class ParticipantesController extends Controller
{
    public function getParticipantes($idSalaDeAula)
    {
        $vinculos = Vinculo::where('idSalaDeAula', $idSalaDeAula)->where('ativo', 1)->get();
        $participantes = [
        'mod' => [],
        'aluno' => []
        ];
        foreach ($vinculos as $vinculo) {
            $aluno = Aluno::find($vinculo->idAluno);
            if ($vinculo->moderadorSala == 1) {
                array_push($participantes['mod'], $aluno);
            } elseif ($vinculo->moderadorSala == 0) {
                array_push($participantes['aluno'], $aluno);
            }
        }
        return view('participantes')->with('alunos', $participantes);
    }
    public function promoverModerador($idAluno, $idSalaDeAula)
    {
        $vinculo = Vinculo::where('idAluno', $idAluno)->where('idSalaDeAula', $idSalaDeAula)->first();
        if ($vinculo->moderadorSala == 0) {
            $vinculo->moderadorSala = 1;
            $vinculo->save();
        } elseif ($vinculo->moderadorSala == 1) {
            $vinculo->moderadorSala = 0;
            $vinculo->save();
        }
        return redirect('/sala_de_aula/c/par/' . session('idSalaDeAula'));
    }
    public function removerAluno($idSalaDeAula, $idAluno)
    {
        $vinculo = Vinculo::where('idSalaDeAula', $idSalaDeAula)->where('idAluno', $idAluno)->first();
        $vinculo->delete();
        return redirect('/sala_de_aula/c/par/' . $idSalaDeAula);
    }
}
