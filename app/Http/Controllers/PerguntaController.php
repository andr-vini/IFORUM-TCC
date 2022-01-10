<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Comentario;
use App\Models\Pergunta;
use App\Models\Resposta;
use App\Models\Usuario;
use App\Models\ItemUsuario;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PerguntaController extends Controller
{
    public function getPergunta($idPergunta)
    {
        $pergunta = Pergunta::with('usuario')->where('idPergunta', $idPergunta)->first();
        $resposta = Resposta::with('usuario')->where('idPergunta', $idPergunta)->get();
        $comentarios = [];
        $items = [
            'perguntas' => [],
            'respostas' => [],
            'comentarios' => [
                'autor' => [],
                'item' => []
            ]
        ];
        foreach ($resposta as $resp) {
            $comentario = Comentario::with('usuario')->where('idResposta', $resp->idResposta)->get();
            array_push($comentarios, $comentario);
            foreach ($comentario as $coment) {
                $itemComentario = ItemUsuario::where('matricula', $coment->matricula)->where('equipado', 1)->first();
                if ($itemComentario != null) {
                    $item = Item::find($itemComentario->idItem);
                    array_push($items['comentarios']['autor'], $itemComentario);
                    array_push($items['comentarios']['item'], $item);
                }
            }
        }
        $usuario = Usuario::find($pergunta->matricula);
        $itemPergunta = ItemUsuario::where('matricula', $pergunta->matricula)->where('equipado', 1)->first();
        if ($itemPergunta != null) {
            $item = Item::find($itemPergunta->idItem);
            array_push($items['perguntas'], $item);
        }
        foreach ($resposta as $resp) {
            $itemResposta = ItemUsuario::where('matricula', $resp->matricula)->where('equipado', 1)->first();
            if ($itemResposta != null) {
                $item = Item::find($itemResposta->idItem);
                array_push($items['respostas'], $item);
            }
        }
        return view('perguntas')
        ->with('pergunta', $pergunta)
        ->with('resposta', $resposta)
        ->with('usuario', $usuario)
        ->with('item', $items)
        ->with('comentarios', $comentarios);
    }
    public function atribuirNotaPergunta(Request $request)
    {
        
        $request->validate([
            'nota' => 'required|max:10|min:1|numeric'
        ]);
        $perg = Pergunta::find($request->get('idPergunta'));
        $perg->nota = $request->get('nota');
        $perg->save();
        $usuario = Usuario::find($perg->matricula);
        $aluno = Aluno::find($usuario->tipo_id);
        $aluno->pontuacao = $request->get('nota');
        $aluno->save();
        return Redirect::back();
    }
    public function atribuirNotaResposta(Request $request)
    {
        $request->validate([
            'nota' => 'required|max:10|min:1|numeric'
        ]);
        $resp = Resposta::find($request->get('idResposta'));
        $resp->nota = $request->get('nota');
        $resp->save();
        $usuario = Usuario::find($resp->matricula);
        $aluno = Aluno::find($usuario->tipo_id);
        $aluno->pontuacao = $request->get('nota');
        $aluno->save();
        return Redirect::back();
    }
    public function publicarResposta(Request $request)
    {   
        $request->validate([
            'resposta' => 'required'
        ]);
        $resposta = new Resposta(['texto' => $request->get('resposta')]);
        $resposta->idPergunta = $request->get('idPergunta');
        $resposta->matricula = session('usuario')->matricula;
        $resposta->save();
        return Redirect::back();
    }
    public function publicarComentario(Request $request)
    {
        $request->validate([
            'comentario' => 'required'
        ]);
        $comentario = new Comentario(['texto' => $request->get('comentario')]);
        $comentario->matricula = session('usuario')->matricula;
        $comentario->idResposta = $request->get('idResposta');
        $comentario->save();
        return Redirect::back();
    }
    public function darLike($matricula, $idPergunta)
    {
        $pergunta = Pergunta::find($idPergunta);
        $usuario = Usuario::find($matricula);
        if ($pergunta->likes()->where('usuarios.matricula', $matricula)->first() == null) {
            $pergunta->likes()->save($usuario);
            return Redirect::back();
        }
        return Redirect::back()->with('like', 'Você já deu like');
    }
}
