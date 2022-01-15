<?php

namespace App\Http\Controllers;

use App\Classes\SUAPDocente;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Item;
use App\Models\ItemUsuario;
use App\Models\Professor;
use App\Models\Usuario;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;

class UsuarioController extends Controller
{
    public function autenticacao(Request $request)
    {
        try {
            $suap = new SUAPDocente();
            $autenticar = $suap->autenticar($request->get('matricula'), $request->get('senha'));
            $resp = $suap->getMeusDados();
            session()->put('token', $autenticar['token']);
        } catch (ClientException $e) {
            return Redirect::back()->with('erro_msg', 'Credenciais inválidas');
        } catch (ServerException $e) {
            return Redirect::back()->with('erro_msg', 'Ocorreu um erro, por favor tente novamente');
        }

        $usuario = Usuario::with('tipo')->where('matricula', $request->get('matricula'))->first();
        $item_usuario = ItemUsuario::where('matricula', $request->get('matricula'))->where('equipado', 1)->first();
        if ($item_usuario != null) {
            $item_equipado = Item::find($item_usuario->idItem);
        }
        //verifica de o que o usuário é no sistema e se encarrega de realizar o login
        if ($usuario != null) {
            session()->put('usuario', $usuario);
            if ($item_usuario != null) {
                session()->put('item_equipado', $item_equipado);
            }
            return redirect('/turmas');
        } else {
            //direciona para a pagina de cadastro de acordo com o vinculo com a instituição
            session()->put('usuario', 'nao cadastrado');
            return redirect()->action(
                [UsuarioController::class, 'criarUsuario'],
                ['vinculo' => $resp['tipo_vinculo']]
            );
        }
    }

    public function criarUsuario($vinculo)
    {
        return view('cadastro')->with('vinculo', $vinculo);
    }

    public function cadastro(Request $request)
    {
        $suap = new SUAPDocente(session('token'));
        $dados_usuario = $suap->getMeusDados();
        $mensagens = [
            'email' => 'Digite um email válido'
        ];
        if ($dados_usuario['tipo_vinculo'] == 'Servidor') {
            $request->validate([
            'apelido' => 'required|max:50',
            'email' => 'required|email'
            ], $mensagens);
        } elseif ($dados_usuario['tipo_vinculo'] == 'Aluno') {
            $request->validate([
                'apelido' => 'required|max:50'
            ]);
        }

        $usuario = new Usuario();
        $usuario->matricula = $dados_usuario['matricula'];
        $usuario->apelido = $request->get('apelido');
        if ($dados_usuario['tipo_vinculo'] == 'Aluno') {
            $aluno = new Aluno(['moderador' => 0]);
            $aluno->save();
            $aluno->usuario()->save($usuario);
        } else {
            try {
                $professor = new Professor(['email' => $request->get('email')]);
                $professor->save();
            } catch (QueryException $e) {
                if ($e->getCode() == 23000) {
                    return Redirect::back()->with('erro_msg', 'O email cadastrado já existe');
                }
            }
            $professor->usuario()->save($usuario);
        }
        $usuario = Usuario::with('tipo')->where('matricula', $dados_usuario['matricula'])->first();
        $item_usuario = ItemUsuario::where('matricula', $request->get('matricula'))->where('equipado', 1)->first();
        if ($item_usuario != null) {
            $item_equipado = Item::find($item_usuario->idItem);
            session()->put('item_equipado', $item_equipado);
        }
        session()->put('usuario', $usuario);
        return redirect('/turmas');
    }
}