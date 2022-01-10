<?php

use App\Http\Controllers\LojaController;
use App\Http\Controllers\ParticipantesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PerguntaController;
use App\Http\Controllers\RankingController;
use App\Http\Middleware\Autenticacao;
use App\Http\Controllers\TurmasController;
use App\Http\Controllers\SalaDeAulaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::post('/autenticacao', [UsuarioController::class, 'autenticacao']);
/*---------------------------------*/

Route::middleware(Autenticacao::class)->group(function () {
    Route::post('/sala_de_aula/c/p/c', [PerguntaController::class, 'publicarComentario']);
    Route::get('/pergunta/like/{matricula}/{idPergunta}', [PerguntaController::class, 'darLike']);
    Route::post('/cadastro', [UsuarioController::class, 'cadastro']);
    Route::get('/perfil', [PerfilController::class, 'getPerfil']);
    Route::get('/turmas', [TurmasController::class, 'getTurmas']);
    Route::get('/sala_de_aula/c/ran', [RankingController::class, 'getRanking']);
    Route::get('/sala_de_aula/c/sda/{idSalaDeAula}', [SalaDeAulaController::class, 'getSalaDeAula']);
    Route::get('/sala_de_aula/c/par/{idSalaDeAula}', [ParticipantesController::class, 'getParticipantes']);
    Route::get('/encerrar_sessao', [PerfilController::class, 'sair']);
    /*---------------------------------*/
    Route::get('/criar_sala', [TurmasController::class, 'pegarDiario']);
    Route::get('/_criar_sala', [TurmasController::class, 'criarSalaDeAula']);
    /*---------------------------------*/
    Route::get('/sala_de_aula/c/mod/{idAluno}/{idSalaDeAula}', [ParticipantesController::class, 'promoverModerador']);
    Route::get('/sala_de_aula/c/rem/{idSalaDeAula}/{idAluno}', [ParticipantesController::class, 'removerAluno']);
    Route::get('/sala_de_aula/p/{status}/{id}', [SalaDeAulaController::class, 'aceitarPerguntas']);
    Route::post('/sala_de_aula/c/p/{idSalaDeAula}', [SalaDeAulaController::class, 'publicarPergunta']);
    Route::get('/sala_de_aula/c/per/{idPergunta}', [PerguntaController::class, 'getPergunta']);
    Route::post('/sala_de_aula/c/nP/', [PerguntaController::class, 'atribuirNotaPergunta']);
    Route::post('/sala_de_aula/c/nR/', [PerguntaController::class, 'atribuirNotaResposta']);
    Route::post('/sala_de_aula/c/r/', [PerguntaController::class, 'publicarResposta']);
    Route::get('/turmas/c/{status}/{id}', [TurmasController::class, 'aceitarConvite']);
    /*---------------------------------*/
    Route::get('/criar_usuario/{vinculo}', [UsuarioController::class, 'criarUsuario']);
    Route::get('/loja/{pag?}', [LojaController::class, 'getItems']);
    Route::get('/loja/comprar/{idItem}', [LojaController::class, 'comprarItems']);
    // mover de lugar
    Route::get('/convite/{idSalaDeAula}', [SalaDeAulaController::class, 'convidar']);
    Route::get('/perfil/equipar/{idItem}', [PerfilController::class, 'equiparItem']);
    Route::post('/convite/enviarConvite/{idSalaDeAula}', [SalaDeAulaController::class, 'enviarConvite']);
});
