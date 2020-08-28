<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class Contract extends FormRequest
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
            'owner' => 'required',
            'acquirer' => 'required|different:owner', //ele é obrigatorio e diferente do owner
            'purpouse' => 'required',
            'sale_price' => 'required_if:sale,on', //ele é requerido se sale estiver checado
            'rent_price' => 'required_if:rent,on',
            'property' => 'required|integer',
            'due_date' => 'required|integer|min:1|max:28', // dia do vencimento, sempre utilizado ate o dia 28 devido os meses de 29, 30 e 31
            'deadline' => 'required|integer|min:12|max:48',
            'start_at' => 'required',
            'rent' => 'different:sale', //nao permite que os checkbox sejam selecionados ao mesmo tempo
        ];
    }
}
