<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use SebastianBergmann\Environment\Console;

class FilterController extends Controller
{


    //========================================
    //SELECIONANDO SEARCH
    //========================================
    public function search(Request $request)
    {

        //sempre que for selecionado alguma categoria, tem que disparar o reet de todas as outra seleçoes posteriores, isso caso o usuario volte a seleçõ para esse campo e altere
        //se ja existe a funcao category, tenho que remover. Para caso o cliente volte a mudar o rent ou sale, apos ja ter selecionado a categoria. Ou seja tem que zeras as informações ja lancadas
        session()->remove('category');
        session()->remove('type');
        session()->remove('neighborhood');
        session()->remove('bedrooms');
        session()->remove('suites');
        session()->remove('bathrooms');
        session()->remove('garage');
        session()->remove('price_base');
        session()->remove('price_limit');





        //session()->put('nome da varial que iremos criar para receber o valor do request', $request->search)

        if ($request->search === 'buy') {
            session()->put('sale', true);
            session()->remove('rent');
            //usando a funcao privada, conseguimos obter os dados selecionados no campo comprar ou alugar e devolvemos os tipos associados a esses valores na coluna categoria
            $properties = $this->createQuery('category');
        }
        if ($request->search === 'rent') {
            session()->put('rent', true);
            session()->remove('sale');
            $properties = $this->createQuery('category');
        }

        if ($properties->count()) {
            foreach ($properties as $categoryProperty) {
                //pegamos o valor category e salvamos no array
                $category[] = $categoryProperty->category;
            }

            //usando as collection do laravel para remover os valores duplicados
            $collect = collect($category);

            //retornando usando o metodo setResponse(com sucesso(encontrou registros), os dados se duplicação, mensagem nao precisa)
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }




    //========================================
    //SELECIONANDO CATEGORY
    //========================================
    public function category(Request $request)
    {
        session()->remove('type');
        session()->remove('neighborhood');
        session()->remove('bedrooms');
        session()->remove('suites');
        session()->remove('bathrooms');
        session()->remove('garage');
        session()->remove('price_base');
        session()->remove('price_limit');

        //search -varivel recebido pelo js
        session()->put('category', $request->search);
        //usando a funcao privada, conseguimos obter os dados selecionados no campo categoria e devolvemos os tipos associados a esses valores na coluna tipo
        $typeProperties = $this->createQuery('type');

        if ($typeProperties->count()) {
            foreach ($typeProperties as $property) {
                //pegamos o valor type e salvamos no array
                $type[] = $property->type;
            }


            //usando as collection do laravel para remover os valores duplicados
            $collect = collect($type);

            //retornando usando o metodo setResponse(com sucesso(encontrou registros), os dados se duplicação, mensagem nao precisa)
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }




    //========================================
    //SELECIONANDO TYPE
    //========================================
    public function type(Request $request)
    {
        session()->remove('neighborhood');
        session()->remove('bedrooms');
        session()->remove('suites');
        session()->remove('bathrooms');
        session()->remove('garage');
        session()->remove('price_base');
        session()->remove('price_limit');

        //search -varivel recebido pelo js
        session()->put('type', $request->search);
        //usando a funcao privada, conseguimos obter os dados selecionados no campo tipo e devolvemos os tipos associados a esses valores na coluna bairro
        $neighborhoodProperties = $this->createQuery('neighborhood');

        if ($neighborhoodProperties->count()) {
            foreach ($neighborhoodProperties as $property) {
                //pegamos o valor neighborhood e salvamos no array
                $neighborhood[] = $property->neighborhood;
            }


            //usando as collection do laravel para remover os valores duplicados
            $collect = collect($neighborhood);

            //retornando usando o metodo setResponse(com sucesso(encontrou registros), os dados se duplicação, mensagem nao precisa)
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }


    //========================================
    //SELECIONANDO NEIGHTBORHOOD
    //========================================
    public function neighborhood(Request $request)
    {
        session()->remove('bedrooms');
        session()->remove('suites');
        session()->remove('bathrooms');
        session()->remove('garage');
        session()->remove('price_base');
        session()->remove('price_limit');

        //search -varivel recebido pelo js
        session()->put('neighborhood', $request->search);
        //usando a funcao privada, conseguimos obter os dados selecionados no campo tipo e devolvemos os tipos associados a esses valores na coluna bairro
        $bedroomsProperties = $this->createQuery('bedrooms');

        if ($bedroomsProperties->count()) {
            foreach ($bedroomsProperties as $property) {
                //pegamos o valor neighborhood e salvamos no array
                //para apresentar a palavra quarto ou quartos no select
                if ($property->bedrooms === 0 || $property->bedrooms === 1) {
                    $bedrooms[] = $property->bedrooms . ' quarto';
                } else {
                    $bedrooms[] = $property->bedrooms . ' quartos';
                }
            }
            //criar opção para o cliente escolher caso esse campo nao faca diferenca prara ele
            $bedrooms[] = 'Indiferente';


            //usando as collection do laravel para remover os valores duplicados e transformando em arraym para ser ordenado pelo sort
            $collect = collect($bedrooms)->unique()->toArray();

            //devolvendo os valores ordenados
            sort($collect);

            //retornando usando o metodo setResponse(com sucesso(encontrou registros), os dados se duplicação, mensagem nao precisa)
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }




    //========================================
    // SELECIONANDO BEDROOMS
    //========================================
    public function bedrooms(Request $request)
    {
        session()->remove('suites');
        session()->remove('bathrooms');
        session()->remove('garage');
        session()->remove('price_base');
        session()->remove('price_limit');

        //search -varivel recebido pelo js
        session()->put('bedrooms', $request->search);
        //usando a funcao privada, conseguimos obter os dados selecionados no campo tipo e devolvemos os tipos associados a esses valores na coluna bairro
        $suitesProperties = $this->createQuery('suites');

        if ($suitesProperties->count()) {


            foreach ($suitesProperties as $property) {

                if ($property->suites === 0 || $property->suites === 1) {
                    //pegamos o valor neighborhood e salvamos no array
                    $suites[] = $property->suites . ' suíte';
                } else {
                    $suites[] = $property->suites . ' suítes';
                }
            }
            $suites[] = 'Indiferente';


            //usando as collection do laravel para remover os valores duplicados
            $collect = collect($suites)->unique()->toArray();
            sort($collect);



            //retornando usando o metodo setResponse(com sucesso(encontrou registros), os dados se duplicação, mensagem nao precisa)
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }


    //========================================
    // SELECIONANDO SUITES
    //========================================
    public function suites(Request $request)
    {
        session()->remove('bathrooms');
        session()->remove('garage');
        session()->remove('price_base');
        session()->remove('price_limit');

        //search -varivel recebido pelo js
        session()->put('suites', $request->search);
        //usando a funcao privada, conseguimos obter os dados selecionados no campo tipo e devolvemos os tipos associados a esses valores na coluna bairro
        $bathroomsProperties = $this->createQuery('bathrooms');

        if ($bathroomsProperties->count()) {


            foreach ($bathroomsProperties as $property) {

                if ($property->bathrooms === 0 || $property->bathrooms === 1) {
                    //pegamos o valor bathrooms e salvamos no array
                    $bathrooms[] = $property->bathrooms . ' banheiro';
                } else {
                    $bathrooms[] = $property->bathrooms . ' banheiros';
                }
            }
            $bathrooms[] = 'Indiferente';


            //usando as collection do laravel para remover os valores duplicados
            $collect = collect($bathrooms)->unique()->toArray();
            sort($collect);



            //retornando usando o metodo setResponse(com sucesso(encontrou registros), os dados se duplicação, mensagem nao precisa)
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }


    //========================================
    // SELECIONANDO BATHROOMS
    //========================================
    public function bathrooms(Request $request)
    {


        session()->remove('garage');
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('bathrooms', $request->search);

        //iremos pegar tanto a garagem como a garagem coberta
        //no querybuildes, no momento de lancar a coluna, inserimos um explode, para delimitar pela ,
        $garageProperties = $this->createQuery('garage,garage_covered');

        if ($garageProperties->count()) {
            foreach ($garageProperties as $property) {

                //criando a variavel soma entre as garagens e garagens cobertas
                $property->garage =  $property->garage +  $property->garage_covered;

                if ($property->garage === 0 || $property->garage === 1) {

                    $garage[] = $property->garage . ' garage';
                } else {
                    $garage[] = $property->garage . ' garagens';
                }
            }
            $garage[] = 'Indiferente';

            $collect = collect($garage)->unique()->toArray();
            sort($collect);

            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }


    //========================================
    // SELECIONANDO GARAGE
    //========================================
    public function garage(Request $request)
    {
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('garage', $request->search);

        //verificando se foi selecionado a opção sale ou rent, para apresentar o valor certo
        //usamos o alias as para deixar somente uma variavel final, no caso price
        if (session('sale') === true) {
            $priceBaseProperties = $this->createQuery('sale_price as price');
        } else {
            $priceBaseProperties = $this->createQuery('rent_price as price');
        }


        if ($priceBaseProperties->count()) {
            foreach ($priceBaseProperties as $property) {

                //como os dados que estamos obtendo do property, nao estao passando pelo MODELO PROPERTY, temos que formatar o valor recebido
                $price[] = 'À partir de R$ ' . number_format($property->price, 2, ',', '.');
            }

            $collect = collect($price)->unique()->toArray();
            sort($collect);

            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }



    //========================================
    // SELECIONANDO PREÇO BASE
    //========================================
    public function priceBase(Request $request)
    {

        session()->remove('price_limit');

        //recebo o valor selecionado em Preço Base
        session()->put('price_base', $request->search);


        //verifico se foi compra ou venda
        if (session('sale') === true) {
            //tratar o valor recebido e evniamos a coluna que tem q ser feita a comparação
            $priceLimitProperties = $this->createQuery('sale_price as price');
        } else {
            $priceLimitProperties = $this->createQuery('rent_price as price');
        }


        if ($priceLimitProperties->count()) {
            foreach ($priceLimitProperties as $property) {

                //como os dados que estamos obtendo do property, nao estao passando pelo MODELO PROPERTY, temos que formatar o valor recebido
                $price[] = 'Até R$ ' . number_format($property->price, 2, ',', '.');
            }

            $collect = collect($price)->unique()->toArray();
            sort($collect);

            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function priceLimit(Request $request)
    {
        session()->put('price_limit', $request->search);
        return response()->json($this->setResponse('success', []));
    }




    //========================================
    //QUERYBUILDER
    //========================================

    //funcao privada para retornar os valores de acordo com o session informada e a coluna informada($fiel)
    //trabalhando com queryBuilder

    public function createQuery($field)
    {
        //quando sale ou rent for selecionado
        $sale = session('sale');
        $rent = session('rent');
        //quando category for selecionado
        $category = session('category');
        $type = session('type');
        $neighborhood = session('neighborhood');
        $bedrooms = session('bedrooms');
        $suites = session('suites');
        $bathrooms = session('bathrooms');
        $garage = session('garage');
        $priceBase = session('price_base'); //defino uma variavel para receber o valor recebido
        $priceLimit = session('price_limit');

        //retornar os valores da tabela selecionada de acordo com o valor recebido pela variavel search js
        //when - quando
        return DB::table('properties')
            ->when($sale, function ($query, $sale) {
                return $query->where('sale', $sale);
            })
            ->when($rent, function ($query, $rent) {
                return $query->where('rent', $rent);
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when($type, function ($query, $type) { //para o tipo podemos selecionar mais de um. Por isso o whereIn
                return $query->whereIn('type', $type);
            })
            ->when($neighborhood, function ($query, $neighborhood) { //para o tipo podemos selecionar mais de um. Por isso o whereIn
                return $query->whereIn('neighborhood', $neighborhood);
            })
            ->when($bedrooms, function ($query, $bedrooms) {

                //caso o cliente escolha a opção indiferente
                if ($bedrooms == 'Indiferente') {
                    return $query;
                }
                //removendo a palavra quarto ou quartos e enviando somente os numeros
                $bedrooms = (int) $bedrooms;
                return $query->where('bedrooms', $bedrooms);
            })
            ->when($suites, function ($query, $suites) {

                //caso o cliente escolha a opção indiferente
                if ($suites == 'Indiferente') {
                    return $query;
                }
                //removendo a palavra quarto ou quartos e enviando somente os numeros
                $suites = (int) $suites;
                return $query->where('suites', $suites);
            })
            ->when($bathrooms, function ($query, $bathrooms) {

                //caso o cliente escolha a opção indiferente
                if ($bathrooms == 'Indiferente') {
                    return $query;
                }
                //removendo a palavra quarto ou quartos e enviando somente os numeros
                $bathrooms = (int) $bathrooms;
                return $query->where('bathrooms', $bathrooms);
            })
            ->when($garage, function ($query, $garage) {

                //caso o cliente escolha a opção indiferente
                if ($garage == 'Indiferente') {
                    return $query;
                }

                $garage = (int) $garage;
                return $query->whereRaw('(garage + garage_covered = ? OR garage = ? OR garage_covered = ?)', [$garage, $garage, $garage]); //whereRaw - faz uma pesquisa bruta, tanto garage sozinho como a soma com o garage_covered, como o garage_covered sozinho
            })
            ->when($priceBase, function ($query, $priceBase) {

                //caso o cliente escolha a opção indiferente
                if ($priceBase == 'Indiferente') {
                    return $query;
                }
                //temos que pegar os dados da pagina web e deixar no formato do banco para podemors fazer a comparaçao na query
                //como estamos pegando o valor diretamente do pagina home, temos que tratar os dados para serem apresentados
                //vamos usar o explode para delimitaar entre o R$, vamos utilizar o valor [1],  ==== ou seja ===== [0], delimitador (R$),[1] . Aqui recebemos o valor somente
                //subistituir o .(ponto) por nada
                //subistituir a ,(virgula) por .(ponto)
                $priceBase = (float) str_replace(',', '.', str_replace('.', '', explode('R$', $priceBase, 2)[1]));
                //agora que tenho o valor salvo na $priceBase
                //temos que saber se é um imovel de compra ou aluguel
                if (session('sale') == true) {
                    return $query->where('sale_price', '>=', $priceBase);
                } else {
                    return $query->where('rent_price', '>=', $priceBase);
                }
            })
            ->when($priceLimit, function ($query, $priceLimit) {


                if ($priceLimit == 'Indiferente') {
                    return $query;
                }

                $priceLimit = (float) str_replace(',', '.', str_replace('.', '', explode('R$', $priceLimit, 2)[1]));

                if (session('sale') == true) {
                    return $query->where('sale_price', '<=', $priceLimit);
                } else {
                    return $query->where('rent_price', '<=', $priceLimit);
                }
            })
            ->get(explode(',', $field));
    }



    //========================================
    //CLEARALLDATA - usado para limpar todos sessions quando o usuario selecionar diretamente os menus alugar e comprar, pois nao ira gerar conflito
    //========================================
    public function clearAllData()
    {
        session()->remove('sale');
        session()->remove('rent');
        session()->remove('category');
        session()->remove('type');
        session()->remove('neighborhood');
        session()->remove('bedrooms');
        session()->remove('suites');
        session()->remove('bathrooms');
        session()->remove('garage');
        session()->remove('price_base');
        session()->remove('price_limit');
    }

    //========================================
    //SET RESPONSE
    //========================================
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
