<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\User;
use App\Contract;
use App\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{


    //======================================================================
    //APRESENTA TELA LOGIN
    //======================================================================

    public function showLoginForm()
    {

        //criando usuario de teste
        // $user = User::where('id',2);
        //  $user->update([
        //     'email' => 'nelioats@gmail.com',
        //     'password' => password_hash(12345, PASSWORD_DEFAULT)
        //]);

        //    // verificando se ja existe uma sessao criada
        if (Auth::check() === true) {
            return redirect()->route('admin.home');
        }
        return view('admin.index');
    }

    //======================================================================
    //APRESENTA TELA HOME
    //======================================================================

    public function home()

    {

        //alimentado a dashboard
        //chamando os scopes dos lessors e lessees
        $lessors = User::lessors()->count();
        $lessees = User::lessees()->count();

        $team = User::where('admin', 1)->count();

        //chamando os scopes 
        $propertyAvailable = Property::available()->count();
        $propertyUnavailable = Property::unavailable()->count();
        $propertyTotal = Property::all()->count();

        //chamando os scopes 
        $contractsPendent = Contract::pendent()->count();
        $contractsActivet = Contract::active()->count();
        $contractsCanceled = Contract::canceled()->count();
        $contractsTotal = Contract::all()->count();

        //Últimos Contratos Cadastrados
        $contracts = Contract::orderBy('id', 'DESC')->limit(10)->get();

        //Últimos Imóveis Cadastrados
        $properties = Property::orderBy('id', 'DESC')->limit(3)->get();

        return view('admin.dashboard', compact(
            'lessors',
            'lessees',
            'team',
            'propertyAvailable',
            'propertyUnavailable',
            'propertyTotal',
            'contractsPendent',
            'contractsActivet',
            'contractsCanceled',
            'contractsTotal',
            'contracts',
            'properties'
        ));
    }

    //======================================================================
    //RECEBE REQUISIÇAO PARA EFETUAR O LOGIN
    //======================================================================

    public function login(Request $request)
    {

        //se todos campos não estiverem preenchidos
        if (($request->email == '') || ($request->password == '')) {
            $request->session()->flash('error', 'Ops, informe todos os dados solicitados!');

            return redirect()->route('admin.login');
        }
        //se o email não for válido
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $request->session()->flash('error', 'Ops, informe um e-mail válido!');
            return redirect()->route('admin.login');
        }



        //verifica se as credencias são as mesmas do banco.
        $credentials = $request->only('email', 'password');






        if (Auth::attempt($credentials)) {

            //verificando se é um usuario admin, se nao for, retorna para login
            if (!$this->isAdmin()) {
                Auth::logout();
                $request->session()->flash('error', 'Ops, usuário não tem permissão para acessar o painel de controle!');
                return redirect()->route('admin.login');
            }



            //salvar o utlimo acesso e o ip do usuario
            $this->autenticado($request->getClientIp());

            return redirect()->route('admin.home');
        } else {

            $request->session()->flash('error', 'Ops, usuário e senha não correspondem!');
            return redirect()->route('admin.login');
        }
    }

    //======================================================================
    //DURANTE A REQUISICAO DO LOGIN É SALVO O IP E A DATA DO ACESSO
    //======================================================================

    public function autenticado(string $ip)
    {
        $user = User::where('id', Auth::user()->id);
        $user->update([
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $ip
        ]);
    }

    //======================================================================
    //LOGOUT
    //======================================================================  

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    //======================================================================
    //VERIFICANDO SE O USUARIO É UM ADMIN
    //======================================================================  
    public function isAdmin()
    {
        $user = User::where('id', Auth::user()->id)->first();


        if ($user->admin === 1) {
            return true;
        } else {
            return false;
        }
    }
}
