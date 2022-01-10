<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Item;
use App\Models\ItemUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Redirect;

class LojaController extends Controller
{
    public function getItems($pag = 1)
    {
        $items = Item::all()->where('categoria', $pag);
        $item_usuario = ItemUsuario::where('matricula', session('usuario')->matricula)->get();
        $idItems = [];
        //pega os id's dos items que o usuário já possui
        foreach ($item_usuario as $item) {
            $id = Item::where('idItem', $item->idItem)->first();
            array_push($idItems, $id->idItem);
        }
        //remove do array de items os items que tem o id igual aos que o usuário possui
        foreach ($items as $item) {
            for ($i = 0; $i < count($idItems); $i++) {
                if ($item->idItem == $idItems[$i]) {
                    unset($items[$item->idItem - 1]);
                }
            }
        }
        return view('loja')->with('items', $items);
    }
    public function comprarItems($idItem)
    {
        $pontuacao = Usuario::find(session('usuario')->matricula);
        $item = ItemUsuario::where('matricula', session('usuario')->matricula)->where('idItem', $idItem)->first();
        $preco = Item::where('idItem', $idItem)->first();
        //adiciona no banco somente se o usuário já não possuir o item
        if ($item == null && $preco->preco <= $pontuacao->tipo->pontuacao) {
            $item_usuario = new ItemUsuario();
            $item_usuario->equipado = 0;
            $item_usuario->idItem = $idItem;
            $item_usuario->matricula = session('usuario')->matricula;
            $item_usuario->save();
            $aluno = Aluno::find($pontuacao->tipo_id);
            $aluno->pontuacao -= $preco->preco;
            $aluno->save();
            session()->put('pontuacao', $aluno->pontuacao);
        }
        return Redirect::back();
    }
}
