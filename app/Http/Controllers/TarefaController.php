<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarefa;
use App\UserStory;
use Session;
use App\GitAPI;
use App\User;

class TarefaController extends Controller
{
    public function criarTarefa(Request $req)
    {
        $dados = $req->all();
        Tarefa::create($dados);
        return redirect()->back()->withSuccess('Tarefa criada com sucesso!');
    }

    public function editarTarefa($id)
    {
        $tarefa = Tarefa::find($id);
        $user = User::where('provider_id', $tarefa->responsavel_id)->first();
        $dados = array($tarefa, $user);
        return $dados;
    }

    public function atualizarTarefa(Request $req, $id)
    {
        $dados = $req->all();
        Tarefa::find($id)->update($dados);
        return redirect()->back();
    }

    public function deletarTarefa($id)
    {
        Tarefa::find($id)->delete();
        return redirect()->back()->withSuccess('Tarefa deletada com sucesso!');
    }


    public function buscarKanbanUS($id)
    {
        Session::put('idUS', $id);
        $registro = UserStory::find($id);
        $tarefas = Tarefa::where('us_id', $id)->get();
        $api = new GitAPI();
        $projeto = $api->buscarProjeto(Session::get("projetoId"));
        $fullname = $projeto->full_name;
        $colaboradores = $api->buscarColaboradoresProjeto($fullname);
        $nomeProjeto = Session::get("nomeProjeto");
        foreach ($colaboradores as $colaborador) {
            $user = User::where('provider_id', $colaborador->id)->first();
            if (!$user) {
                // add user to database
                $user = User::create([
                    'email' => "",
                    'name' => "$colaborador->login",
                    'provider_id' => "$colaborador->id",
                    'provider_token' => "",
                    'avatar_url' => "$colaborador->avatar_url",
                    'nickname' => "$colaborador->login"
                ]);
            }
        }
        return view('tarefas.painel-kanban-us', compact('registro', 'id', 'tarefas', 'colaboradores', 'nomeProjeto'));
    }

    public function atualizarStatusTarefa($id, $status)
    {
        $tarefa = Tarefa::find($id);
        $tarefa->update([
            'status' => $status
        ]);
    }
}
