<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Company as CompanyRequest;


class CompanyController extends Controller
{
 
    public function index()
    {
        $companies = Company::all();
        return view('admin.companies.index',compact('companies'));
    }

 
    public function create(Request $request)
    {

        $users = User::orderBy('name')->get();

        //se existe e é diferente de vazio
        if(!empty($request->user)){
            $user = User::where('id',$request->user)->first();
        }

        
        return view('admin.companies.create',[
            'users' => $users,
            //se for diferente de vazio ? devolve $user : devolve null 
            'selected'  => (!empty($user) ? $user : null)
        ]);
    }

   
    public function store(CompanyRequest $request)
    {
    //    usamos esse bloco de codigo para verificar se os dados estão indo tratados
    //    $company = new Company();
    //    $company->fill($request->all());
    //    dd($company);
        
        $companyCreate = Company::create($request->all());
        dd($companyCreate);


    }

 
    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        $company = Company::where('id',$id)->first();
        $users = User::orderBy('name')->get();
        return view('admin.companies.edit' ,compact('company','users'));
    }

   
    public function update(CompanyRequest $request, $id)
    {
        $company = Company::where('id',$id)->first();
        $company->fill($request->all());
        //dd($company->getAttributes());
        $company->save();

         //se deu tudo certo
         return redirect()->route('admin.companies.edit',['company'=>$company->id])
         ->with(['message' => 'Empresa atualizada com sucesso!']);
    }

 
    public function destroy($id)
    {
        //
    }
}
