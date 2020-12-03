<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GitAPI;
use Session;
use App\UserStory;
use App\Diagrama;

class ProjetoController extends Controller
{
    public function listaTodosProjetos()
    {
        $projeto = new GitAPI();
        $listaProjetos = $projeto->buscaTodosProjetos();

        //busca contribuidores dos projetos e cria um campo 'contribuidores' na lista de projeotos
        for ($i = 0; $i < count($listaProjetos); $i++) {
            $retorno = $projeto->buscarColaboradoresProjeto($listaProjetos[$i]->full_name);
            if (isset($retorno[0]->login)) {
                $listaProjetos[$i]->contribuidores = $retorno;
            } else {
                $listaProjetos[$i]->contribuidores = $listaProjetos[$i]->owner;
            }
        }
        if (isset($listaProjetos)) {
            return view('projeto.lista-projetos', compact('listaProjetos'));
        }
        // Alert::warning('Ops!', 'Faça login com sua conta do gitHub para atualizar seus projetos!');
        return view('projeto.lista-projetos');
    }

    public function voltar()
    {
        return redirect()->back();
    }

    public function abrirProjeto($projetoId)
    {
        Session::put('projetoId', $projetoId);
        //consulta qual é o numero total de US
        $historias = UserStory::where('projeto_git_id', $projetoId)->get();
        $numHistorias = count($historias);

        //busca também os diagramas
        $diagramas = Diagrama::where('projeto_git_id', $projetoId)->get();

        return view('projeto.unico-projeto', compact('numHistorias', 'diagramas', 'historias'));
    }

    /**
     * Método para retornar para a tela do projeto unico
     */
    public function voltarPainelProjeto()
    {
        $idProjeto = Session::get('projetoId');
        //consulta qual é o numero total de US
        $registros = UserStory::where('projeto_git_id', $idProjeto)->get();
        $numHistorias = count($registros);

        $historias = UserStory::where('projeto_git_id', $idProjeto)->get();
        $numHistorias = count($historias);

        //busca também os diagramas
        $diagramas = Diagrama::where('projeto_git_id', $idProjeto)->get();

        return view('projeto.unico-projeto', compact('numHistorias', 'diagramas', 'historias'));
    }

    public function cadastrarProjeto(Request $req)
    {
        $dados = $req->all();

        $validator = $this->getValidationFactory()
            ->make($req->all(), [
                'nome' => 'required|min:5|max:50',
                'descricao' => 'required|min:5|max:100',
                'tipo' => 'required',
            ], [
                'nome.required' => 'O campo nome é obrigatório!',
                'nome.min' => 'O campo nome deve conter no mínimo 5 caracteres!',
                'nome.max' => 'O campo descricao deve ter no máximo 50 caracteres!',

                'descricao.required' => 'O campo descricao é obrigatório!',
                'descricao.min' => 'O campo descricao deve conter no mínimo 5 caracteres!',
                'descricao.max' => 'O campo descricao deve ter no máximo 100 caracteres!',
                'tipo.required'  => 'Selecione o tipo do repositório',

            ]);

        if ($validator->fails()) {
            $mensagem = $validator->errors()->first();
            return redirect()->back()->with('warning', $mensagem);
        }

        $nome = $dados['nome'];
        $descricao = $dados['descricao'];
        $tipo = (bool) $dados['tipo'];

        $dados = array(
            "name" => "$nome",
            "description" => "$descricao",
            "homepage" => null,
            "private" => $tipo,
            "has_issues" => false,
            "has_projects" => false,
            "has_wiki" => false
        );

        $projeto = new GitAPI();
        $retorno = $projeto->criarProjeto($dados);
        if (isset($retorno->id)) {
            return redirect()->back()->with('success', 'Projeto cadastrado com sucesso!');
        } else {
            return redirect()->back()->withInput()->withErrors(['Erro de comunicação com o servidor. Tente novamente mais tarde.']);
        }
    }

    public function editarProjeto($idProjeto)
    {
        $projeto = new GitAPI();
        $registro = $projeto->buscarProjeto($idProjeto);

        if (isset($registro->id)) {
            return view('projeto.atualizar-projeto', compact('registro'));
        } else {
            return redirect()->back()->withInput()->withErrors(['Erro de comunicação com o servidor. Tente novamente mais tarde.']);
        }
    }

    public function atualizarProjeto(Request $req)
    {
        $dadosForm = $req->all();

        $validator = $this->getValidationFactory()
            ->make($req->all(), [
                'nome' => 'required|min:5|max:50',
                'descricao' => 'required|min:5|max:100',
                'tipo' => 'required',
            ], [
                'nome.required' => 'O campo nome é obrigatório!',
                'nome.min' => 'O campo nome deve conter no mínimo 5 caracteres!',
                'nome.max' => 'O campo descricao deve ter no máximo 50 caracteres!',

                'descricao.required' => 'O campo descricao é obrigatório!',
                'descricao.min' => 'O campo descricao deve conter no mínimo 5 caracteres!',
                'descricao.max' => 'O campo descricao deve ter no máximo 100 caracteres!',
                'tipo.required'  => 'Selecione o tipo do repositório',

            ]);

        if ($validator->fails()) {
            $mensagem = $validator->errors()->first();
            return redirect()->back()->with('warning', $mensagem);
        }

        $nome = $dadosForm['nome'];
        $descricao = $dadosForm['descricao'];
        $tipo = (bool) $dadosForm['tipo'];
        $dono = $dadosForm['dono'];
        $nomeRepositorio = $dadosForm['nomeRepositorio'];

        $dados = array(
            "name" => "$nome",
            "description" => "$descricao",
            "homepage" => null,
            "private" => $tipo,
            "has_issues" => false,
            "has_projects" => false,
            "has_wiki" => false
        );

        $projeto = new GitAPI();
        $retorno = $projeto->atualizarProjeto($dados, $dono, $nomeRepositorio);

        if (isset($retorno->id)) {
            return redirect()->back()->with('success', 'Projeto atualizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro de comunicação com o servidor. Tente novamente mais tarde.');
        }
    }

    public function deletarProjeto($idProjeto)
    {
        $projeto = new GitAPI();
        $registro = $projeto->buscarProjeto($idProjeto);
        $dono = $registro->owner->login;
        $nomeRepositorio = $registro->name;

        $retorno = $projeto->deletarProjeto($dono, $nomeRepositorio);

        if ($retorno) {
            return redirect()->route('home')->with('success', 'Projeto removido sucesso!');
        } else {
            return redirect()->route('home')->with('error', 'Erro de comunicação com o servidor. Tente novamente mais tarde.');
        }
    }
}
