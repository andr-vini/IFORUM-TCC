<?php

namespace App\Http\Controllers;

use App\Classes\SUAPDocente;
use Illuminate\Http\Request;
use App\Models\SalaDeAula;
use App\Models\Professor;
use App\Models\Usuario;
use App\Models\Vinculo;
use Illuminate\Support\Facades\Redirect;

class TurmasController extends Controller
{
    public function pegarDiario(Request $request)
    {
        $request->validate([
            'ano' => 'required|max:2022|min:2000|numeric',
            'periodo' => 'required|max:2|min:1|numeric'
        ]);
        $suap = new SUAPDocente(session('token'));
        session()->put('diario', $suap->getMeusDiarios($request->get('ano'), $request->get('periodo')));
        session()->put('ano', $request->get('ano'));
        session()->put('periodo', $request->get('periodo'));
        return view('criacao_sala')->with('diarios', $suap->getMeusDiarios($request->get('ano'), $request->get('periodo')));
    }
    public function criarSalaDeAula(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:200|min:10|string',
        ]);
        $salaDeAula = new SalaDeAula([
        'nome' => $request->get('nome'),
        'ano' => session('ano'),
        'periodo' => session('periodo'),
        'idDiario' => session('diario')[$request->get('diario')]['id']
        ]);
        $salaDeAula->idProfessor = session('usuario')->tipo->idProfessor;
        $salaDeAula->save();
        session()->forget('diario');
        session()->forget('ano');
        session()->forget('periodo');
        return redirect('/turmas');
    }
    public function getTurmas()
    {
        PerfilController::getPontuacao();
        if (session()->has('idSalaDeAula') == true) {
            session()->forget('idSalaDeAula');
            session()->forget('nome');
        }
        if (session('usuario')->tipo_type == 'App\Models\Professor') {
            $professores = [];
            $salas = [];
            $salaDeAula = Professor::find(session('usuario')->tipo_id)->saladeaulas()->get();
            foreach ($salaDeAula as $sala) {
                $professor = Usuario::where('tipo_id', $sala->idProfessor)->where('tipo_type', 'App\Models\Professor')->first();
                array_push($salas, $sala);
                array_push($professores, $professor);
            }
            return view('turmas')->with('salaDeAula', $salaDeAula)->with('professores', $professores);
        }

        if (session('usuario')->tipo_type == 'App\Models\Aluno') {
            $salasPendentes = [];
            $convites = [];
            $professoresPendente = [];
            $salasParticipanteConvitePendente = Vinculo::where('idAluno', session('usuario')->tipo_id)->where('status', 2)->get();

            foreach ($salasParticipanteConvitePendente as $convite) {
                array_push($convites, $convite);
            }
            foreach ($salasParticipanteConvitePendente as $sala) {
                $salaDeAula = SalaDeAula::where('idSalaDeAula', $sala->idSalaDeAula)->first();
                $professor = Usuario::where('tipo_id', $salaDeAula->idProfessor)->where('tipo_type', 'App\Models\Professor')->first();
                array_push($salasPendentes, $salaDeAula);
                array_push($professoresPendente, $professor);
            }

            $salasAceitas = [];
            $professoresAceitos = [];
            $salasParticipanteConviteAceito = Vinculo::where('idAluno', session('usuario')->tipo_id)->where('status', 1)->get();
            foreach ($salasParticipanteConviteAceito as $sala) {
                $salaDeAula = SalaDeAula::where('idSalaDeAula', $sala->idSalaDeAula)->first();
                $professor = Usuario::where('tipo_id', $salaDeAula->idProfessor)->where('tipo_type', 'App\Models\Professor')->first();
                array_push($salasAceitas, $salaDeAula);
                array_push($professoresAceitos, $professor);
            }
            return view('turmas')->with('salaDeAulasPendentes', $salasPendentes)->with('professoresPendentes', $professoresPendente)->with('salaDeAula', $salasAceitas)->with('professores', $professoresAceitos)->with('convites', $convites);
        }
        return view('turmas');
    }
    public function aceitarConvite($status, $id)
    {
        $vinculo = Vinculo::find($id);
        if ($status == 1) {
            $vinculo->status = 1;
            $vinculo->ativo = 1;
            $vinculo->save();
        } elseif ($status == 0) {
            $vinculo->delete();
        }
        return Redirect::back();
    }
}
