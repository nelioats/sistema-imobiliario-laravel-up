<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class Property extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user" => "required", 
            "category" => "required",
            "type" => "required",
            "sale_price" => "required_if:sale,on", //ele é requerido somente se o campo sale for on
            "rent_price" => "required_if:rent,on", //ele é requerido somente se o campo sale for on
            "tribute" => "required",
            "condominium" => "required",
            "description" => "required",
            "bedrooms" => "required",
            "suites" => "required",
            "bathrooms" => "required",
            "rooms" => "required",
            "garage" => "required",
            "garage_covered" => "required",
            "area_total" => "required",
            "area_util" => "required",

            //Endereço
            'zipcode' => 'required|min:8|max:9',
            'street' => 'required',
            'number' => 'required',
            'complement' => 'required',
            'neighborhood' => 'required',
            'state' => 'required',
            'city' => 'required',

        ];
    }
}
