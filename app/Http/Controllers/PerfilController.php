<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Aluno;
use App\Models\ItemUsuario;
use App\Models\Item;
use App\Models\Pergunta;
use App\Models\Resposta;
use Illuminate\Support\Facades\Redirect;

class PerfilController extends Controller
{
    public function getPerfil()
    {
        $usuario = Usuario::with('tipo')->where('matricula', session('usuario')->matricula)->first();
        $items = [];
        $items_user = ItemUsuario::where('matricula', session('usuario')->matricula)->get();
        $perguntas = Pergunta::where('matricula', session('usuario')->matricula)->get();
        $respostas = Resposta::where('matricula', session('usuario')->matricula)->get();
        foreach ($items_user as $item) {
            $ite = Item::where('idItem', $item->idItem)->first();
            array_push($items, $ite);
        }
        $this->getPontuacao();
        return view('perfil')->with('usuario', $usuario)->with('email', $usuario->tipo->email)->with('items', $items)->with('contPerguntas', count($perguntas))->with('contRespostas', count($respostas));
    }

    public function sair()
    {
        session()->flush();
        return redirect('/');
    }

    public static function getPontuacao()
    {
        if (session('usuario')->tipo_type == 'App\Models\Aluno') {
            $aluno = Aluno::where('idAluno', session('usuario')->tipo_id)->first();
            session()->put('pontuacao', $aluno->pontuacao);
            return view('turmas');
        }
    }
    public static function equiparItem($idItem)
    {
        ItemUsuario::where('matricula', session('usuario')->matricula)->where('idItem', $idItem)->update(['equipado' => 1]);
        ItemUsuario::where('matricula', session('usuario')->matricula)->where('idItem', '!=', $idItem)->update(['equipado' => 0]);
        $item_equipado = Item::find($idItem);
        session()->put('item_equipado', $item_equipado);
        return Redirect::back();
    }
}
