<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use Exception;

class GitAPI extends Model
{

    // private $idUsuario;

    // function __construct()
    // {
    //     $this->idUsuario = Session::get('idUser');
    // }

    /**
     * Busca os projeto que eu sou dono e colaborador;
     */
    public function buscaTodosProjetos()
    {
        $curl_url = 'https://api.github.com/user/repos';
        $curl_token_auth = 'Authorization: token ' . Session::get("access_token");
        $ch = curl_init($curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }

    /**
     * fullname é o nome do dono do projeto concatenado com o nome do projeto.
     * Ex: fullname = "programacUnipampa/Resolve"
     */
    public function buscarContribuidoresProjeto($fullName)
    {
        $curl_url = "https://api.github.com/repos/$fullName/contributors";
        $curl_token_auth = 'Authorization: token ' . Session::get("access_token");
        $ch = curl_init($curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }

    public function buscarColaboradoresProjeto($fullName)
    {
        $curl_url = "https://api.github.com/repos/$fullName/collaborators";
        $curl_token_auth = 'Authorization: token ' . Session::get("access_token");
        $ch = curl_init($curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }

    public function criarProjeto($dados)
    {
        $dados = json_encode($dados);
        $curl_url = "https://api.github.com/user/repos";
        $curl_token_auth = 'Authorization: token ' . Session::get("access_token");
        $ch = curl_init($curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
    }

    /**
     * Busca os dados de um usuário;
     */
    public function buscarUsuario()
    {
        $curl_url = 'https://api.github.com/user';
        $curl_token_auth = 'Authorization: token ' . Session::get("access_token");
        $ch = curl_init($curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth, 'Accept: application/vnd.github.v3+json'));
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output;
        //validacao
    }

    /**
     * Busca dados de um projeto específico
     */
    public function buscarProjeto($idProjeto)
    {
        try {
            $curl_url = "https://api.github.com/repositories/$idProjeto";
            $curl_token_auth = 'Authorization: token ' . Session::get("access_token");
            $ch = curl_init($curl_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth, 'Accept: application/vnd.github.inertia-preview+json'));
            $output = curl_exec($ch);
            // $info = curl_getinfo($ch);
            curl_close($ch);
            $output = json_decode($output);
            return $output;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    /**
     * Atualiza os dados de um projeto específico
     */
    public function atualizarProjeto($dados, $dono, $nomeRepositorio)
    {
        try {
            $curl_url = "https://api.github.com/repos/$dono/$nomeRepositorio";
            $dados = json_encode($dados);
            $curl_token_auth = 'Authorization: token ' . Session::get("access_token");
            $ch = curl_init($curl_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth, 'Accept: application/vnd.github.v3+json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);
            return $output;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    public function deletarProjeto($dono, $nomeRepositorio)
    {
        try {
            $url = "https://api.github.com/repos/$dono/$nomeRepositorio";
            $curl_token_auth = 'Authorization: token ' . Session::get("access_token");
            $header = array('User-Agent: Awesome-Octocat-App',  $curl_token_auth, "Accept:  application/vnd.github.v3+json");
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            $result = curl_exec($ch);
            $result = json_decode($result);
            // $info = curl_getinfo($ch);
            curl_close($ch);
            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }
}
