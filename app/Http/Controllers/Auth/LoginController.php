<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Auth;
use Session;
use App\GitAPI;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->setScopes(['read:user', 'repo', 'delete_repo', 'repo:status', 'repo_deployment'])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        //esse primeiro bloco faz a requisição para conseguir o token de acesso a API, ele trabalha com o retorno da primeira
        //requisição feita pelo socialite
        if (!isset($_SESSION['access_token'])) {
            $state = Session::get("state");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://github.com/login/oauth/access_token");
            curl_setopt($ch, CURLOPT_POST, TRUE);
            $header = array('Accept: application/json');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'code' => $_GET['code'],
                'client_id' => env('GITHUB_CLIENT_ID'),
                'client_secret' => env('GITHUB_CLIENT_SECRET'),
                'redirect_uri' => env('GITHUB_CALLBACK'),
                'state' => $state,
                'scope' => 'repo',
                'grant_type' => "authorization_code"
            ));
            $data = curl_exec($ch);
            $data = json_decode($data);
            if (isset($data->error)) {
                return dd($data);
            }
            Session::put("access_token", $data->access_token);
            Session::put("token_type", $data->token_type);
        }


        //esse bloco verifica a existencia do usuário localmente, se não exsiste ele atualiza o token e autentica o usuário


        $git = new GitAPI();
        $retorno = $git->buscarUsuario();

        $user = User::where('provider_id', $retorno->id)->first();
        if (!$user) {
            // add user to database
            $user = User::create([
                'email' => "$retorno->email",
                'name' => "$retorno->login",
                'provider_id' => "$retorno->id",
                'provider_token' => Session::get('access_token'),
                'avatar_url' => "$retorno->avatar_url",
                'nickname' => "$retorno->login"
            ]);
        } else {
            $user->update([
                'provider_token' => Session::get('access_token')
            ]);
        }

        Auth::login($user, true);
        Session::put('idUser', $retorno->id);

        return redirect($this->redirectTo);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('https://github.com/logout');
    }
}
