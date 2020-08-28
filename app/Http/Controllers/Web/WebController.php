<?php

namespace App\Http\Controllers\Web;

use App\Property;
use App\Mail\Web\Contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Web\FilterController;

class WebController extends Controller
{
    public function home()
    {

        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS imóveis',
            'Descricao de Teste - Encontre seu imovel dos sonhos',
            route('web.home'),
            asset('frontend/assets/images/share.png')
        );


        //usando a concatenação dos scopes(sale e available) conseguimos obter os imoves para venda e disponiveis
        $propertyForSale = Property::sale()->available()->limit(3)->get();
        $propertyForRent = Property::rent()->available()->limit(3)->get();

        return view('web.home', compact('head', 'propertyForSale', 'propertyForRent'));
    }


    public function rent()
    {

        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS imóveis',
            'Descricao de Teste - Alugue o imovel dos seus sonhos',
            route('web.rent'),
            asset('frontend/assets/images/share.png')
        );

        //chamando o clearAllData para limpar todas as sessions para nao gerar conflito
        $filter = new FilterController();
        $filter->clearAllData();


        //trabalhando com a pagina alugar
        $properties = Property::rent()->available()->get();

        return view('web.filter', [
            'properties' => $properties,
            //enviar uma variavel o tipo type pra diferenciar o imovel dentro da view filter
            'type' => 'rent',
            'head' => $head
        ]);
    }




    public function rentProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();

        //incrementar a coluna views
        //podemos usar o metodo do eloquent $property->increment('views'); ou  na logica mesmo como abaixo
        $property->views = $property->views + 1;
        $property->save();

        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS imóveis',
            $property->headline ?? $property->title, //caso nao encontre o headline, retorna o title
            route('web.rentProperty', ['slug' => Str::slug($property->slug)]),
            $property->cover()
        );





        return view('web.property', [
            'property' => $property,
            'type' => 'rent',
            'head' => $head
        ]);
    }



    public function buy()
    {

        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS imóveis',
            'Descricao de Teste - Compre o imovel dos seus sonhos',
            route('web.buy'),
            asset('frontend/assets/images/share.png')
        );

        //chamando o clearAllData para limpar todas as sessions para nao gerar conflito
        $filter = new FilterController();
        $filter->clearAllData();


        //trabalhando com a pagina alugar
        $properties = Property::sale()->available()->get();

        return view('web.filter', [
            'properties' => $properties,
            //enviar uma variavel o tipo type pra diferenciar o imovel dentro da view filter
            'type' => 'sale',
            'head' => $head
        ]);
    }

    public function buyProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();

        //incrementar a coluna views
        //podemos usar o metodo do eloquent $property->increment('views'); ou  na logica mesmo como abaixo
        $property->views = $property->views + 1;
        $property->save();


        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS imóveis',
            $property->headline ?? $property->title, //caso nao encontre o headline, retorna o title
            route('web.buyProperty', ['slug' => Str::slug($property->slug)]),
            $property->cover()
        );


        return view('web.property', [
            'property' => $property,
            'type' => 'sale',
            'head' => $head
        ]);
        //dd($property);
    }



    public function filter()
    {

        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS imóveis',
            'Descricao de Teste - Filtre o imovel dos seus sonhos',
            route('web.filter'),
            asset('frontend/assets/images/share.png')
        );


        $filter = new FilterController();
        //capturado os ids dos imoveis pesquisados
        $itemProperties = $filter->createQuery('id');

        foreach ($itemProperties as $property) {
            //criamos o array $properties[] para armazenar os ids dos imoveis selecionados
            $properties[] = $property->id;
        }

        //se $properties[] foi alimentado alguma vez
        if (!empty($properties)) {
            //iremos chamar o modelo Property para retornar os imoveis atraves dos ids
            //whereIn - varios objetos dentro de uma coluna
            $properties = Property::whereIn('id', $properties)->get();
        }
        //caso o usuario selecione o endereço sem o filtro da pagina, retornamos todos imoveis para serem aoresentados
        else {
            $properties = Property::all();
        }


        return view('web.filter', compact('head', 'properties'));
    }





    public function contato()
    {

        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS imóveis experiencias',
            'Quer conversar com um corretor exclusivo e ter o atendimento diferenciado em busca do seu imóvel dos sonhos? Entre em contato com nossa equipe',
            route('web.contact'),
            asset('frontend/assets/images/share.png')
        );


        return view('web.contact', [
            'head' => $head
        ]);
    }

    public function experience()
    {

        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS imóveis',
            'Descricao de Teste - Viva a experiência de encontrar o imovel dos seus sonhos',
            route('web.experience'),
            asset('frontend/assets/images/share.png')
        );

        //chamando o clearAllData para limpar todas as sessions para nao gerar conflito
        $filter = new FilterController();
        $filter->clearAllData();

        //listar todos imoveis que pertence a uma experiencia, whereNotNull, que nao tem o campo experience como null
        $properties = Property::whereNotNull('experience')->get();

        return view('web.filter', [
            'properties' => $properties,
            'head' => $head
        ]);
    }


    public function experienceCategory(Request $request)
    {






        //chamando o clearAllData para limpar todas as sessions para nao gerar conflito
        $filter = new FilterController();
        $filter->clearAllData();

        if ($request->slug == 'cobertura') {

            //inserir somente em dois para teste
            $head =  $this->seo->render(
                env('APP_NAME') . '- NATS imóveis',
                'Descricao de Teste - Viva a experiência de morar na cobertura',
                route('web.experienceCategory', ['slug' => 'cobertura']),
                asset('frontend/assets/images/share.png')
            );
            $properties = Property::where('experience', 'Cobertura')->get();
        } elseif ($request->slug == 'alto-padrao') {

            $head =  $this->seo->render(
                env('APP_NAME') . '- NATS imóveis',
                'Descricao de Teste - Viva a experiência de morar num imovel de alto padrao',
                route('web.experienceCategory', ['slug' => 'alto-padrao']),
                asset('frontend/assets/images/share.png')
            );
            $properties = Property::where('experience', 'Alto Padrão')->get();
        } elseif ($request->slug == 'de-frente-para-o-mar') {
            $properties = Property::where('experience', 'De Frente para o Mar')->get();
        } elseif ($request->slug == 'condominio-fechado') {
            $properties = Property::where('experience', 'Condomínio Fechado')->get();
        } elseif ($request->slug == 'compacto') {
            $properties = Property::where('experience', 'Compacto')->get();
        } elseif ($request->slug == 'lojas-e-salas') {
            $properties = Property::where('experience', 'Lojas e Salas')->get();
        } else {
            //caso nao tenha selelcionado nenhuma opcao
            $properties = Property::whereNotNull('experience')->get();
        }

        //caso o head esteja vazio
        if (empty($head)) {
            $head =  $this->seo->render(
                env('APP_NAME') . '- NATS imóveis experiencias',
                'Descricao de Teste - Viva nos melhores imoveis do pais!',
                route('web.experience'),
                asset('frontend/assets/images/share.png')
            );
        }



        return view('web.filter', [
            'properties' => $properties,
            'head' => $head
        ]);
    }

    public function spotlight()
    {
        $head =  $this->seo->render(
            env('APP_NAME') . '- NATS destaque',
            'Descricao de Teste - Confira os melhores imoveis do pais!',
            route('web.spotlight'),
            asset('frontend/assets/images/share.png')
        );


        return view('web.spotlight', [
            'head' => $head
        ]);
    }

    public function sendEmail(Request $request)
    {


        $data = [
            'replay_name' => $request->name,
            'replay_email' => $request->email,
            'cell' => $request->cell,
            'message' => $request->message,
        ];

        Mail::send(new Contact($data));

        return redirect()->route('web.sendEmailSuccess');
    }

    public function sendEmailSuccess()
    {
        return view('web.contact_success');
    }
}
