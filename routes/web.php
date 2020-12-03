<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['guest'])->group(function () {


    Route::get('login/github', 'Auth\LoginController@redirectToProvider')->name('login-github');

    Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback')->name('callback');
});

//______________________
Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Projeto 
    Route::get('/projeto/abrir/{id}', 'ProjetoController@abrirProjeto')->name('abrir-projeto');
    Route::get('/projeto/meus-projetos', 'ProjetoController@listaTodosProjetos')->name('meus-projetos');
    Route::get('/projeto/form-cadastrar-projeto', function () {
        return view('projeto/form-cadastrar-projeto');
    })->name('form-cadastrar-projeto');
    Route::post('/projeto/enviar-cadastro-projeto', 'ProjetoController@cadastrarProjeto')->name('cadastrar-projeto');
    Route::get('/projeto/editar/{id}', 'ProjetoController@editarProjeto')->name('editar-projeto');
    Route::post('/projeto/atualizar', 'ProjetoController@atualizarProjeto')->name('atualizar-projeto');
    Route::get('/projeto/deletar/{id}', 'ProjetoController@deletarProjeto')->name('deletar-projeto');
    Route::get('/projeto/abrir', 'ProjetoController@voltarPainelProjeto')->name('voltar-painel');
    Route::get('/projeto/voltar', 'ProjetoController@voltar')->name('voltar');
    //_________________________________________________

    //Colaboradores
    Route::post('/colaboradores/buscar-contribuidores-projeto', 'ProjetoController@buscarContribuidoresProjeto')->name('buscar-contribuidores');
    //_________________________________________________

    //Diagramas
    Route::get('/mermaid', 'ProjetoController@mermaid')->name('mermaid');
    //_________________________________________________

    //Histórias
    Route::get('/us/painel-us', 'UsController@index')->name('painel-us');
    Route::post('/us/criar', 'UsController@criarUS')->name('criar-us');
    Route::get('/us/editar/{id}', 'UsController@editarUS')->name('editar-us');
    Route::post('/us/atualizar/{id}', 'UsController@atualizarUS')->name('atualizar-us');
    Route::get('/us/deletar/{id}', 'UsController@deletarUS')->name('deletar-us');
    Route::get('/us/buscar/{id}', 'UsController@buscarUS')->name('buscar-us');
    Route::get('/us/buscar', 'UsController@buscaTodasUsProjeto')->name('buscar-us-ajax');
    //_________________________________________________

    //Tarefas
    Route::post('/us/tarefa/criar-tarefa', 'TarefaController@criarTarefa')->name('criar-tarefa');
    Route::get('/us/tarefa/editar/')->name('editar-tarefa-ajax');
    Route::get('/us/tarefa/editar/{id}', 'TarefaController@editarTarefa')->name('editar-tarefa');
    Route::post('/us/tarefa/atualizar/{id}', 'TarefaController@atualizarTarefa')->name('atualizar-tarefa');
    Route::post('/us/tarefa/atualizar', 'TarefaController@atualizarTarefa')->name('atualizar-tarefa-ajax');

    //a rota de baixo é pra não ter q reescrever a rota no kanbar para atualizar o status da tarefa
    Route::get('/us/tarefa/deletar/{id}', 'TarefaController@deletarTarefa')->name('deletar-tarefa');
    Route::get('/us/tarefa/deletar/', 'TarefaController@deletarTarefa')->name('deletar-t');

    //a rota de baixo é pra não ter q reescrever a rota no kanbar para deletar a tarefa
    Route::get('/us/tarefa/atualizar-status/{id}/{status}', 'TarefaController@atualizarStatusTarefa')->name('atualizar-status');
    Route::get('/us/tarefa/atualizar-status/', 'TarefaController@atualizarStatusTarefa')->name('atualizar-s');
    //_________________________________________________

    //Kanban
    Route::get('/us/kanban/{id}', 'TarefaController@buscarKanbanUS')->name('kanban-us');
    //_________________________________________________

    //Diagram
    Route::get('/diagrama/painel/{id}', 'DiagramaController@abrirPainelDiagrama')->name('painel-diagrama');
    Route::post('/diagrama/salvar', 'DiagramaController@salvarDiagrama')->name('salvar-diagrama');
    Route::post('/diagrama/atualizar', 'DiagramaController@atualizarDiagrama')->name('atualizar-diagrama');
    Route::get('/diagrama/abrir/{id}', 'DiagramaController@abrirDiagrama')->name('abrir-diagrama');
    Route::get('/diagrama/deletar/{id}', 'DiagramaController@deletarDiagrama')->name('deletar-diagrama');

    Route::get('/diagrama/removerassociacao/{id}', 'DiagramaController@removerAssociacao')->name('remover-associacao-diagrama');
    Route::post('/diagrama/associar', 'DiagramaController@associarRequisito')->name('associar-requisito');

    //_________________________________________________


    //Logout
    Route::get('/sair', 'Auth\LoginController@logout')->name('sair');

    //Teste
    Route::get('/teste', 'Auth\LoginController@teste')->name('teste');
    //_________________________________________________
});
