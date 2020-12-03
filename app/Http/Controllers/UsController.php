<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserStory;
use App\GitAPI;
use Session;

class UsController extends Controller
{

    public function index()
    {
        $idProjeto = Session::get('projetoId');
        $registros = UserStory::where('projeto_git_id', $idProjeto)->get();
        $projeto = new GitAPI();
        $projeto = $projeto->buscarProjeto($idProjeto);
        $idProjeto = Session::put("nomeProjeto", $projeto->name);
        return view('user-story.painel-us', compact('registros', 'projeto'));
    }

    public function buscaTodasUsProjeto()
    {
        $idProjeto = Session::get('projetoId');
        $historias = UserStory::where('projeto_git_id', $idProjeto)->get();
        return compact('historias');
    }

    public function consultaNumTotalUS()
    {
        $idProjeto = Session::get('projetoId');
        $registros = UserStory::where('projeto_git_id', $idProjeto)->get();
        dd(count($registros));
    }

    public function criarUS(Request $req)
    {

        $validator = $this->getValidationFactory()
            ->make($req->all(), [
                'descricao' => 'required|min:7|max:200',
                'pontuacao' => 'required|numeric',
                'prioridade' => 'required'
            ], [
                'pontuacao.required' => 'O tempo estimado da US é obrigatório!',
                'pontuacao.numero' => 'O campo tempo estimado aceita apenas valores numéricos!',

                'descricao.required' => 'O campo descricao é obrigatório!',
                'descricao.min' => 'O campo descricao deve conter no mínimo 7 caracteres!',
                'descricao.max' => 'O campo descricao deve ter no máximo 200 caracteres!',

                'prioridade.required'  => 'É obrigatório informar a prioridade.',

            ]);

        if ($validator->fails()) {
            $mensagem = $validator->errors()->first();
            return redirect()->back()->with('warning', $mensagem);
        }

        $idProjeto = Session::get('projetoId');
        $dados = $req->all();
        $descricao = $dados['descricao'];
        $pontuacao = $dados['pontuacao'];
        $prioridade = $dados['prioridade'];
        $status = 'Análise';

        $us = array(
            "descricao" => "$descricao",
            "pontuacao" => "$pontuacao",
            "prioridade" => "$prioridade",
            "status" => "$status",
            "projeto_git_id" => "$idProjeto"
        );

        UserStory::create($us);
        return redirect()->back()->with('success', 'US criada com sucesso!');
    }

    public function editarUS($id)
    {
        $nomeProjeto = Session::get('nomeProjeto');
        $registro = UserStory::find($id);
        return view('user-story.form-editar-us', compact('registro', 'nomeProjeto'));
    }

    public function atualizarUS(Request $req, $id)
    {
        $validator = $this->getValidationFactory()
            ->make($req->all(), [
                'descricao' => 'required|min:7|max:100',
                'pontuacao' => 'required|numeric',
                'prioridade' => 'required'
            ], [
                'pontuacao.required' => 'O tempo estimado da US é obrigatório!',
                'pontuacao.numero' => 'O campo tempo estimado aceita apenas valores numéricos!',

                'descricao.required' => 'O campo descricao é obrigatório!',
                'descricao.min' => 'O campo descricao deve conter no mínimo 7 caracteres!',
                'descricao.max' => 'O campo descricao deve ter no máximo 100 caracteres!',

                'prioridade.required'  => 'É obrigatório informar a prioridade.',

            ]);

        if ($validator->fails()) {
            $mensagem = $validator->errors()->first();
            return redirect()->back()->with('warning', $mensagem);
        }

        $dados = $req->all();
        UserStory::find($id)->update($dados);
        return redirect()->route('painel-us')->with('success', 'US atualizada!');
    }

    public function deletarUS($id)
    {
        UserStory::find($id)->delete();
        return redirect()->route('painel-us')->with('success', 'US removida com sucesso!');
    }
}
