<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Property;
use App\PropertyImage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Property as PropertyRequest;

class PropertyController extends Controller
{

    public function index()
    {
        $properties = Property::orderBy('id', 'DESC')->get();
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {

        //para enviar todos usaurios para escolha de qual usuario é o propietario
        $users = User::orderBy('name')->get();

        return view('admin.properties.create', compact('users'));
    }

    public function store(PropertyRequest $request)
    {
        //para tratamento dos campos, com os set, antes de serem enviados p o banco
        // $property = new Property();
        // $property->fill($request->all());

        $createProperty = Property::create($request->all());


        //SALVANDO AS IMAGENS NO MODELO PropertyImage
        //$request->allFiles['files'] : [files] é o unico indice criado pelo allFiles, onde dentro dele que tem varios indices de imagens
        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $propertyImage = new PropertyImage();
                $propertyImage->property = $createProperty->id;
                $propertyImage->path = $image->storeAs('properties/' . $createProperty->id, Str::slug($request->title) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension()); //diretorio onde sera salvo //diretorio onde sera salvo
                $propertyImage->save();
                unset($propertyImage); //destruir variavel para limpar memoria
            }
        }

        //após salvar ele é redirecionado para route de edição enviando o id e a mensagem
        return redirect()->route('admin.properties.edit', ['property' => $createProperty->id])
            ->with(['message' => 'Imóvel cadastrado com sucesso!']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {

        $property = Property::where('id', $id)->first();

        //testar os get sobre a varivel sale_price
        //dd($property->sale_price,$property->rent_price, $property->getAttributes());

        //para enviar todos usaurios para escolha de qual usuario é o propietario
        $users = User::orderBy('name')->get();

        return view('admin.properties.edit', compact('property', 'users'));
    }

    public function update(PropertyRequest $request, $id)
    {

        $property = Property::where('id', $id)->first();
        $property->fill($request->all());

        //em caso de remover a seleção dos checkbox, não será enviado nada, para isso chamamos novamete o metodo SET para definir 0 nesses casos
        $property->setSaleAttribute($request->sale);
        $property->setRentAttribute($request->rent);
        $property->setAirConditioningAttribute($request->air_conditioning);
        $property->setBarAttribute($request->bar);
        $property->setLibraryAttribute($request->library);
        $property->setBarbecueGrillAttribute($request->barbecue_grill);
        $property->setAmericanKitchenAttribute($request->american_kitchen);
        $property->setFittedKitchenAttribute($request->fitted_kitchen);
        $property->setPantryAttribute($request->pantry);
        $property->setEdiculeAttribute($request->edicule);
        $property->setOfficeAttribute($request->office);
        $property->setBathtubAttribute($request->bathtub);
        $property->setFirePlaceAttribute($request->fireplace);
        $property->setLavatoryAttribute($request->lavatory);
        $property->setFurnishedAttribute($request->furnished);
        $property->setPoolAttribute($request->pool);
        $property->setSteamRoomAttribute($request->steam_room);
        $property->setViewOfTheSeaAttribute($request->view_of_the_sea);

        $property->save();

        //SALVANDO AS IMAGENS NO MODELO PropertyImage
        //$request->allFiles['files'] : [files] é o unico indice criado pelo allFiles, onde dentro dele que tem varios indices de imagens
        //dd($request->allFiles());
        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $propertyImage = new PropertyImage();
                $propertyImage->property = $property->id;
                $propertyImage->path = $image->storeAs('properties/' . $property->id, Str::slug($property->type) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension()); //diretorio onde sera salvo
                $propertyImage->save();
                unset($propertyImage); //destruir variavel para limpar memoria
            }
        }


        //após salvar ele é redirecionado para route de edição enviando o id e a mensagem
        return redirect()->route('admin.properties.edit', ['property' => $property->id])
            ->with(['message' => 'Imóvel alterado com sucesso!']);
    }

    public function destroy($id)
    {
        //
    }

    public function imageSetCover()
    {
        return response()->json('vc chegou ate aqui!');
    }

    public function imageRemove()
    {
        return response()->json('vc chegou ate aqui para remover!');
    }
}
