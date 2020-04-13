<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User as UserRequest;


class UserController extends Controller
{
   
    public function index()
    {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }

    public function team()
    {
        return view('admin.users.team');
    }

  

   
    public function create()
    {
        return view('admin.users.create');
    }

   
    public function store(UserRequest $request)
    {

        $userCreate = User::create($request->all());
           
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $user = User::where('id',$id)->first();
        return view('admin.users.edit', compact('user'));


    }

   
    public function update(UserRequest $request, $id)
    {
        $user = User::where('id',$id)->first();
        $user->setLessorAttribute($request->lessor);
        $user->setLesseeAttribute($request->lessee);
        $user->setAdminAttribute($request->admin);
        $user->setClientAttribute($request->client);
        
        $user->fill($request->all());

        $user->save();
        
        dd($user);
    }

 
    public function destroy($id)
    {
        //
    }
}
