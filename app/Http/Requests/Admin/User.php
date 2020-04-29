<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
{
  
    public function authorize()
    {
        return Auth::check();
    }


    public function all($keys = null){
       return $this->validateFields(parent::all());
    }

    //funcao para validação do cpf(removendo a mascara para checagem)
    public function validateFields(array $inputs){
        $inputs['document'] = str_replace(['.','-'], '', $this->request->all()['document']);
        //retornamos o array input com o valor do cpf ja formatado para validação do FormRequest
        return $inputs;
    }




    public function rules()
    {
        return [
            'name' => 'required|min:10|max:191',
            'genre' => 'in:male,female,other',
            //na condição ternaria: é diferente de vazio o campo id, se sim, inserimos todas as condiçoes contatenando com a exceção do id logado
            'document' => (!empty($this->request->all()['id']) ?  'required|min:11|max:14|unique:users,document,'. $this->request->all()['id'] : 'required|min:11|max:14|unique:users,document'),
            'document_secondary' => 'required|min:8|max:12',
            'document_secondary_complement' => 'required',
            'date_of_birth' => 'required|date_format:d/m/Y',
            'place_of_birth' => 'required',
            'civil_status' => 'required|in:married,separated,single,divorced,widower',
           
            //RENDA
            'occupation' => 'required',
            'income' => 'required',
            'company_work' => 'required',
            
            //Endereço
            'zipcode' => 'required|min:8|max:9',
            'street' => 'required',
            'number' => 'required',
            'complement' => 'required',
            'neighborhood' => 'required',
            'state' => 'required',
            'city' => 'required',

            //CONTATO
            'telephone'=>'max:14',
            'cell' => 'required',
           
            //ACESSO
            'email' => (!empty($this->request->all()['id']) ? 'required|email|unique:users,email,'.$this->request->all()['id'] : 'required|email|unique:users,email'),
            'password' => 'required',

            //CONJUGE
            'type_of_communion' => 'required_if:civil_status,married,separated|in:Comunhão Universal de Ben,Comunhão Parcial de Bens,Separação Total de Bens,Participação Final de Aquestos',
            'spouse_name' => 'required_if:civil_status,married,separated|min:10|max:191',
            'spouse_genre' => 'required_if:civil_status,married,separated|in:male,female,other',
            'spouse_document' => 'required_if:civil_status,married,separated|min:11|max:14',
            'spouse_document_secondary' => 'required_if:civil_status,married,separated|min:8|max:12',
            'spouse_document_secondary_complement' => 'required_if:civil_status,married,separated',
            'spouse_date_of_birth' => 'required_if:civil_status,married,separated|date_format:d/m/Y',
            'spouse_place_of_birth' => 'required_if:civil_status,married,separated',
            'spouse_occupation' => 'required_if:civil_status,married,separated',
            'spouse_income' => 'required_if:civil_status,married,separated',
            'spouse_company_work' => 'required_if:civil_status,married,separated',

            //'




        ];
    }
}



         