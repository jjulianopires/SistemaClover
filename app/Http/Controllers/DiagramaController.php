<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Image\ImageManager;
use App\Diagrama;
use Session;

class DiagramaController extends Controller
{
    public function abrirPainelDiagrama($tipoDiagrama)
    {
        if ($tipoDiagrama == 1) {
            $diagrama = 'graph TD\n A[Christmas] -->|Get money| B(Go shopping)\n B --> C{Let me think} \nC -->|One| D[Laptop] \nC -->|Two| E[iPhone] \nC -->|Three| F[fa:fa-car Car]';
        } elseif ($tipoDiagrama == 2) {
            // $diagrama = 'classDiagram\nClass01 <|-- AveryLongClass : Cool\nClass03 *-- Class04\nClass05 o-- Class06\nClass07 .. Class08\nClass09 --> C2 : Where am i?\nClass09 --* C3\nClass09 --|> Class07\nClass07 : equals()\nClass07 : Object[] elementData\nClass01 : size()\nClass01 : int chimp\nClass01 : int gorilla\nClass08 <--> C2: Cool label';
            $diagrama = 'classDiagram\nAnimal <|-- Duck\nAnimal <|-- Fish\nAnimal <|-- Zebra\nAnimal : +int age\nAnimal : +String gender\nAnimal: +isMammal()\nAnimal: +mate()\nclass Duck{\n+String beakColor\n+swim()\n+quack()\n}\nclass Fish{\n-int sizeInFeet\n-canEat()\n}\nclass Zebra{\n+bool is_wild\n+run()}';
        } else {
            $diagrama = 'stateDiagram\n[*] --> Still\nStill --> [*]\nStill --> Moving\nMoving --> Still\nMoving --> Crash\nCrash --> [*]';
        }
        return view('artefato.painel-diagramas', compact('diagrama'));
    }

    public function salvarDiagrama(Request $req)
    {
        $dados = $req->all();
        // $imagem = $dados['imagem'];
        // $filename = time() . 'diagrama';
        // Image::make($imagem)->resize(300, 300)->save(public_path('/uploads/diagramas/' . $filename));

        // dd($filename);
        // // if (isset($dados['nomeDiagrama'])) {
        //     dd($dados);
        // }

        $descricao = str_replace("\n", '\n', $dados['descricaoDiagrama']);

        $idProjeto = Session::get('projetoId');
        $responsavel_id = Session::get('idUser');
        $diagrama = array(
            "nome" => "diagrama-" . time(),
            "descricao" => "$descricao",
            "imagem" => null,
            "responsavel_id" => $responsavel_id,
            "us_id" => null,
            "projeto_git_id" => $idProjeto,
        );

        Diagrama::create($diagrama);

        return redirect()->route('abrir-projeto', $idProjeto)->with('success', 'Diagrama salvo com sucesso!');

        // if ($req->hasFile('avatar')) {
        //     $avatar = $req->file('avatar');
        //     $filename = time() . '.' . $avatar->getClientOriginalExtension();
        //     // Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/diagramas/' . $filename ) );


    }


    public function abrirDiagrama($id)
    {
        $registro = Diagrama::where('id', $id)->first();
        $diagrama = $registro->descricao;

        //pesquisa no diagrama aonde tem \r e troca por ''
        $diagrama =  str_replace("\r", '', "$diagrama");


        return view('artefato.painel-atualizar-diagrama', compact('diagrama', 'registro'));
    }

    public function atualizarDiagrama(Request $req)
    {
        $dados = $req->all();
        $descricao = str_replace("\n", '\n', $dados['descricaoDiagrama']);
        $nome = $dados['nomeDiagrama'];
        $idProjeto = Session::get('projetoId');
        $responsavel_id = Session::get('idUser');
        $idDiagrama = $dados['idDiagrama'];
        $diagrama = array(
            "nome" => "$nome",
            "descricao" => "$descricao",
            "imagem" => null,
            "responsavel_id" => $responsavel_id,
            "us_id" => null,
            "projeto_git_id" => $idProjeto,
        );

        Diagrama::find($idDiagrama)->update($diagrama);

        $registro = Diagrama::where('id', $idDiagrama)->first();
        $diagrama = $registro->descricao;

        //pesquisa no diagrama aonde tem \r e troca por ''
        $diagrama =  str_replace("\r", '', "$diagrama");

        return view('artefato.painel-atualizar-diagrama', compact('diagrama', 'registro'))->with('success', 'Diagrama atualizado com sucesso!');
    }

    public function deletarDiagrama($idDiagrama)
    {
        Diagrama::find($idDiagrama)->delete();
        session()->flash('success', 'Diagrama removido com sucesso!');

        return redirect()
            ->back()
            ->withInput();
    }


    public function removerAssociacao($idDiagrama)
    {
        $diagrama = Diagrama::find($idDiagrama);

        if ($diagrama) {
            $diagrama->us_id = null;
            $diagrama->save();
        }
        session()->flash('success', 'Associação removida com sucesso!');

        return redirect()
            ->back()
            ->withInput();
    }

    public function associarRequisito(Request $req)
    {

        $dados = $req->all();

        $idDiagrama = $dados['idDiagramaAssociacao'];
        $us_id = $dados['us_id'];

        $diagrama = Diagrama::find($idDiagrama);

        if ($diagrama) {
            $diagrama->us_id = $us_id;
            $diagrama->save();
        }

        session()->flash('success', 'Requisito associado com sucesso!');

        return redirect()
            ->back()
            ->withInput();
    }
}
