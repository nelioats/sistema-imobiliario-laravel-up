<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


//======================================================================
//APRESENTA TELA LOGIN
//======================================================================

    public function showLoginForm(){

        //criando usuario de teste
        // $user = User::where('id',2);
        //  $user->update([
        //     'email' => 'nelioats@gmail.com',
        //     'password' => password_hash(12345, PASSWORD_DEFAULT)]);

    //    // verificando se ja existe uma sessao criada
        if(Auth::check() === true){
            return redirect()->route('admin.home');
        }
        return view('admin.index');
    }

//======================================================================
//APRESENTA TELA HOME
//======================================================================

    public function home(){
        return view('admin.dashboard');
    }

//======================================================================
//RECEBE REQUISIÇAO PARA EFETUAR O LOGIN
//======================================================================

    public function login(Request $request){

        //se todos campos não estiverem preenchidos
        if(($request->email == '') || ($request->password == '') ){
            Session::flash('success','Ops, informe todos os dados solicitados!');
            return redirect()->route('admin.login');

        }
        //se o email não for válido
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            Session::flash('success','Ops, informe um e-mail válido!');
            return redirect()->route('admin.login');
        }






        //verifica se as credencias são as mesmas do banco.
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            

            //salvar o utlimo acesso e o ip do usuario
            $this->autenticado($request->getClientIp());

            return redirect()->route('admin.home');
        }else{
           
            Session::flash('success','Ops, usuário e senha não correspondem!');
            return redirect()->route('admin.login');
        }





    }

//======================================================================
//DURANTE A REQUISICAO DO LOGIN É SALVO O IP E A DATA DO ACESSO
//======================================================================

    public function autenticado(string $ip){
        $user = User::where('id',Auth::user()->id);
        $user->update([
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $ip]);
    }

//======================================================================
//LOGOUT
//======================================================================  

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }


}
