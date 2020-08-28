<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Support\Cropper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\User as UserRequest;


class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function team()
    {
        //carregando todos usuarios admin, que sao salvos com 1 no banco
        $users = User::where('admin', 1)->get();
        return view('admin.users.team', compact('users'));
    }




    public function create()
    {
        return view('admin.users.create');
    }


    public function store(UserRequest $request)
    {

        // $userCreate = new User();
        // $userCreate->fill($request->all());
        // dd($userCreate->getAttributes());

        //criação do usuario
        $userCreate = User::create($request->all());




        //salvando a imagem
        if (!empty($request->file('cover'))) {
            $userCreate->cover = $request->file('cover')->storeAs('user', Str::slug($request->name, '-') . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover')->extension());
            $userCreate->save();
        }

        //após salvar ele é redirecionado para tela de edição
        return redirect()->route('admin.users.edit', ['user' => $userCreate->id])
            ->with(['message' => 'Cliente cadastrado com sucesso!']);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.users.edit', compact('user'));
    }


    public function update(UserRequest $request, $id)
    {

        //dd($request->all());

        $user = User::where('id', $id)->first();
        //usamos o setLessorAttribute para verificar se o atributo foi selecionado. Se sim, usamos a funcao setLessorAttribute
        $user->setLessorAttribute($request->lessor);
        $user->setLesseeAttribute($request->lessee);
        $user->setAdminAttribute($request->admin);
        $user->setClientAttribute($request->client);


        //Para que seja salva somente uma imagem por usuario.
        //Para verificar se já existe alguma imagem por usuario.
        //É necessário que seja deletada tanto imagem do storage como o diretorio do banco.
        if (!empty($request->file('cover'))) {
            Storage::delete($user->cover);
            Cropper::flush($user->cover);
            $user->cover = '';
        }

        $user->fill($request->all());

        //criando o diretorio onde será armazenado a imagem
        // Verificar se é diferente de vazio, se sim, salva a imagem.
        if (!empty($request->file('cover'))) {
            //no banco dentro da coluna cover = $request->file('cover') = arquivo | ->store('user') = diretorio
            $user->cover = $request->file('cover')->storeAs('user', Str::slug($request->name, '-') . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover')->extension());
        }



        //se ele nao conseguir salvar
        if (!$user->save()) {
            //retornar todos meus inputs com seus erros
            return redirect()->back()->withInput()->withErrors();
        }

        //se deu tudo certo
        return redirect()->route('admin.users.edit', ['user' => $user->id])
            ->with(['message' => 'Cliente atualizado com sucesso!']);




        //dd($user);
    }


    public function destroy($id)
    {
        //
    }
}
