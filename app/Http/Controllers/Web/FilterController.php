<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    public function search(Request $request)
    {
        if ($request->search === 'buy') {
            session()->put('sale', true);
            session()->remove('rent');
            //usando a funcao privada, conseguimos obter os dados de sale 1 para coluna category
            $properties = $this->createQuery('category');
        }
        if ($request->search === 'rent') {
            session()->put('rent', true);
            session()->remove('sale');
            $properties = $this->createQuery('category');
        }

        if ($properties->count()) {
            foreach ($properties as $categoryProperty) {
                $category[] = $categoryProperty->category;
            }

            //usando as collection do laravel para remover os valores duplicados
            $collect = collect($category);

            //retornando usando o metodo setResponse(com sucesso(encontrou registros), os dados se duplicação, mensagem nao precisa)
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    //funcao privada para retornar somente os campos de venda ou aluguel do banco
    //trabalhando com queryBuilder

    private function createQuery($field)
    {
        $sale = session('sale');
        $rent = session('rent');

        //retornar os valores da tabela selecionada
        //when - quando
        //$sale for igual a sale
        return DB::table('properties')
            ->when($sale, function ($query, $sale) {
                return $query->where('sale', $sale);
            })
            ->when($rent, function ($query, $rent) {
                return $query->where('rent', $rent);
            })
            ->get([$field]);
    }

    //preparando o arquivo response
    //ele vai receber
    //string status
    //array data, podendo ser nulo, caso nao tenha valor para paresentar
    //string message, para retorar mensagem em caso de valor nulo, podendo ser nulo caso tenha valor para apresentar 
    private function setResponse(string $status, array $data = null, string $message = null)
    {
        return [
            'status' => $status,
            'data'  => $data,
            'message' => $message
        ];
    }
}
