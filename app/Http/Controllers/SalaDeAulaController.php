<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use App\Models\SalaDeAula;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Classes\SUAPDocente;
use App\Models\Vinculo;

class SalaDeAulaController extends Controller
{
    public function publicarPergunta(Request $request, string $idSalaDeAula)
    {
        $request->validate([
            'pergunta' => 'required'
        ]);
        $pergunta = new Pergunta(['texto' => $request->get('pergunta'), 'status' => 0]);
        $pergunta->matricula = session('usuario')->matricula;
        $pergunta->idSalaDeAula = $idSalaDeAula;
        $pergunta->save();
        return Redirect::back();
    }
    public function getSalaDeAula($idSalaDeAula)
    {
        $sala_perguntas = SalaDeAula::with('pergunta')->where('idSalaDeAula', $idSalaDeAula)->first();
        $vinculo = Vinculo::where('idSalaDeAula', $idSalaDeAula)->where('idAluno', session('usuario')->tipo_id)->first();
        $perguntas = [
            'perguntas_pendentes' => [
                'usuario' => [],
                'pergunta' => []
            ],
            'perguntas_aceitas' => [
                'usuario' => [],
                'pergunta' => [],
                'likes' => [],
                'respostas' => []
            ],
        ];

        foreach ($sala_perguntas->pergunta as $pergunta) {
            $usuario = Usuario::where('matricula', $pergunta->matricula)->first();
            if ($pergunta->status == 0) {
                array_push($perguntas['perguntas_pendentes']['pergunta'], $pergunta);
                array_push($perguntas['perguntas_pendentes']['usuario'], $usuario);
            } elseif ($pergunta->status == 1) {
                $likes = Pergunta::with('likes')->where('idPergunta', $pergunta->idPergunta)->first();
                $respostas = Pergunta::with('respostas')->where('idPergunta', $pergunta->idPergunta)->first();
                array_push($perguntas['perguntas_aceitas']['respostas'], count($respostas->respostas));
                array_push($perguntas['perguntas_aceitas']['likes'], count($likes->likes));
                array_push($perguntas['perguntas_aceitas']['pergunta'], $pergunta);
                array_push($perguntas['perguntas_aceitas']['usuario'], $usuario);
            }
        }
        session()->put('idSalaDeAula', $idSalaDeAula);
        session()->put('nome', $sala_perguntas->nome);
        if(session('usuario')->tipo_type == 'App\Models\Aluno'){
            return view("sala_de_aula")->with('perguntas', $perguntas)->with('moderador', $vinculo->moderadorSala);
        }else{
            return view("sala_de_aula")->with('perguntas', $perguntas);
        }
    }
    public function aceitarPerguntas($status, $id)
    {
        $perg = Pergunta::find($id);
        if ($status == 1) {
            $perg->status = $status;
            $perg->save();
            return Redirect::back();
        } elseif ($status == 0) {
            $perg->delete();
            return Redirect::back();
        }
    }
    public function convidar($idSalaDeAula)
    {
        $diarioSala = SalaDeAula::where('idSalaDeAula', $idSalaDeAula)->first();
        $suap = new SuapDocente(session('token'));
        $diarios = $suap->getMeusDiarios($diarioSala->ano, $diarioSala->periodo);
        $diarioSeparado = null;
        $participantes = [
            'participantesNaoEnviado' => [],
            'participantesEnviado' => [],
            'dadosApiNaoEnviado' => [],
            'dadosApiEnviado' => []
        ];
        foreach ($diarios as $d) {
            if ($d['id'] == $diarioSala->idDiario) {
                $diarioSeparado = $d;
                break;
            }
        }
        foreach ($diarioSeparado['participantes'] as $participante) {
            $seExisteUsuario = Usuario::where('matricula', $participante['matricula'])->first();
            if ($seExisteUsuario != null) {
                $vinculo = Vinculo::where('idAluno', $seExisteUsuario->tipo->idAluno)->where('idSalaDeAula', $idSalaDeAula)->first();
                if ($vinculo == null) {
                    array_push($participantes['participantesNaoEnviado'], $seExisteUsuario);
                    foreach ($diarioSeparado['participantes'] as $aluno) {
                        if ($aluno['matricula'] == $participante['matricula']) {
                            array_push($participantes['dadosApiNaoEnviado'], $aluno);
                        }
                    }
                } elseif ($vinculo != null) {
                    array_push($participantes['participantesEnviado'], $seExisteUsuario);
                    foreach ($diarioSeparado['participantes'] as $aluno) {
                        if ($aluno['matricula'] == $participante['matricula']) {
                            array_push($participantes['dadosApiEnviado'], $aluno);
                        }
                    }
                }
            }
        }
        return view('convite')->with('participantes', $participantes)->with('idSalaDeAula', $idSalaDeAula);
    }
    public function enviarConvite(Request $request, $idSalaDeAula)
    {
        $idAlunos = $request->all();
        unset($idAlunos['_token']);
        foreach ($idAlunos as $key) {
            $vinculo = new Vinculo(['ativo' => 0, 'status' => '2']);
            $vinculo->idAluno = ($key);
            $vinculo->idSalaDeAula = $idSalaDeAula;
            $vinculo->save();
        }
        return redirect('/sala_de_aula/c/sda/' . $idSalaDeAula);
    }
}
