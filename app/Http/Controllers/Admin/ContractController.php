<?php

namespace App\Http\Controllers\Admin;

use App\Contract;
use App\User;
use App\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contract as ContractRequest;

class ContractController extends Controller
{

    public function index()
    {
        //para enviar o usuario do relacionamento, precisamos enviar o relacionamento tmb
        $contracts = Contract::with(['ownerObject', 'acquirerObject'])->orderBy('id', 'DESC')->get();
        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {


        $lessors = User::lessors();
        $lessees = User::lessees();
        return view('admin.contracts.create', compact('lessors', 'lessees'));
    }


    public function store(ContractRequest $request)
    {

        //esse bloco é utiilizado para testar os campos e seus formatos, com os Metodos SET
        // $contract = new Contract();
        // $contract->fill($request->all());
        // dd($contract->getAttributes());



        $contractCreate = Contract::create($request->all());

        return redirect()->route('admin.contracts.edit', ['contract' => $contractCreate->id])
            ->with(['message' => 'Contrato cadastrado com sucesso!']);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

        $contract = Contract::where('id', $id)->first();

        $lessors = User::lessors();
        $lessees = User::lessees();


        return view('admin.contracts.edit', compact('contract', 'lessors', 'lessees'));
    }


    public function update(ContractRequest $request, $id)
    {
        $contract = Contract::where('id', $id)->first();
        $contract->fill($request->all());
        $contract->save();


        //alterando o status do imovel se vai ta disponivel ou não
        if ($request->property) {
            //carregando o imovel atraves do id igual ao $request->property
            $property = Property::where('id', $request->property)->first();
            if ($request->status === 'active') {
                //se tiver ativo é prq o imovel vai ta INDISPONIVEL PARA LOCACAO, no caso 0
                $property->status = 0;
                $property->save();
            } else {
                $property->status = 1;
                $property->save();
            }
        }



        return redirect()->route('admin.contracts.edit', ['contract' => $contract->id])
            ->with(['message' => 'Contrato atualizado com sucesso!']);
    }


    public function destroy($id)
    {
        //
    }

    public function getDataOwner(Request $request)
    {

        //=====================================================================================
        //CARREGANDO OS DADOS DO CONJUGE DO USAURIO SELECIONADO, ATRAVES DO POST JQUERY
        //=====================================================================================

        //recebendo o usuario atraves da requisicao post do jquery
        //podemos no first, filtrar os dados que queremos desse usuario
        $lessor = User::where('id', $request->user)->first([
            'id',
            'civil_status',
            'spouse_name',
            'spouse_document'
        ]);

        //se lessor for diferente de vazio, retornara os dados do suaurio. Caso nao seja selecionado,(no caso se for selecionado o item INFORME O CLIENTE) ,retornaremos null
        if (!empty($lessor)) {

            //iremos retornar as informações, somente se o usuario for casado ou separado.
            //para isso criamos um array com as duas condiçoes
            $civilStatusSpouseRequired = [
                'married',
                'separated'
            ];
            //verificamos se o status do usuario selecionado confere com o array civilStatusSpouseRequired
            //sendo verdadeiro, setamos o 'spouse_name',  'spouse_document' do usuario selecionado
            if (in_array($lessor->civil_status, $civilStatusSpouseRequired)) {
                $spouse = [
                    'spouse_name' => $lessor->spouse_name,
                    'spouse_document' => $lessor->spouse_document
                ];
            } else {
                $spouse = null;
            }

            //Caso nao seja selecionado,(no caso se for selecionado o item INFORME O CLIENTE) ,retornaremos null
        } else {
            $spouse = null;
        }

        //criamos uma posição dotipo json $json['spouse'] para receber o $spouse. Sera enviada pelo json
        $json['spouse'] = $spouse;

        //=====================================================================================
        //CARREGANDO OS DADOS DE COMPANHIAS DO USAURIO SELECIONADO, ATRAVES DO POST JQUERY
        //=====================================================================================
        //verificamos se existe companies, se nao existir devolvemos 0
        if (empty($lessor)) {
            $companies = 0;
        } else {

            //atraves da relacao usuario - companhias que temos no modelo USER
            //retornaremos todas companhias do usuario
            //podemos filtrar os campos que queremos retornar
            $companies = $lessor->companies()->get([
                'id',
                'alias_name',
                'document_company',
            ]);
        }

        //criamos uma posição dotipo json $json['companies'] para receber o $companies. Sera enviada pelo response()->json($json);
        $json['companies'] = $companies;


        //=====================================================================================
        //CARREGANDO OS DADOS DE PROPRIEDADES DO USAURIO SELECIONADO, ATRAVES DO POST JQUERY
        //=====================================================================================
        //verificamos se existe properties, se for vazio, devolvemos 0,  senao chamamos a relação user->properties para obter a coleção de properties
        if (empty($lessor)) {
            $properties = 0;
        } else {

            //obtendo a colecao de properties do usuario
            $getProperties = $lessor->properties()->get();

            //preparando todas as properteis do usuario para enviar pelo json
            foreach ($getProperties as $property) {
                $properties[] = [
                    'id' => $property->id,
                    'description' => '#' . $property->id . ' ' . $property->street . ', '
                        . $property->number . ' ' . $property->neighborhood . ' ' . $property->city . '/'
                        . $property->state . ' (' . $property->zipcode . ')'
                ];
            }
        }
        //criamos uma posição dotipo json $json['properties'] para receber o $properties. Sera enviada pelo response()->json($json);
        $json['properties'] = $properties;



        //=====================================================================================
        //retornarmos a variavel atraves de response pelo json
        return response()->json($json);
    }



    //copiamos e function getDataOwner e editamos
    public function getDataAdquirente(Request $request)
    {

        //=====================================================================================
        //CARREGANDO OS DADOS DO CONJUGE DO Adquirente SELECIONADO, ATRAVES DO POST JQUERY
        //=====================================================================================

        //recebendo o Adquirente atraves da requisicao post do jquery
        //podemos no first, filtrar os dados que queremos desse usuario
        $lessee = User::where('id', $request->user)->first([
            'id',
            'civil_status',
            'spouse_name',
            'spouse_document'
        ]);

        //se lessor for diferente de vazio, retornara os dados do suaurio. Caso nao seja selecionado,(no caso se for selecionado o item INFORME O CLIENTE) ,retornaremos null
        if (!empty($lessee)) {

            //iremos retornar as informações, somente se o usuario for casado ou separado.
            //para isso criamos um array com as duas condiçoes
            $civilStatusSpouseRequired = [
                'married',
                'separated'
            ];
            //verificamos se o status do usuario selecionado confere com o array civilStatusSpouseRequired
            //sendo verdadeiro, setamos o 'spouse_name',  'spouse_document' do usuario selecionado
            if (in_array($lessee->civil_status, $civilStatusSpouseRequired)) {
                $spouse = [
                    'spouse_name' => $lessee->spouse_name,
                    'spouse_document' => $lessee->spouse_document
                ];
            } else {
                $spouse = null;
            }

            //Caso nao seja selecionado,(no caso se for selecionado o item INFORME O CLIENTE) ,retornaremos null
        } else {
            $spouse = null;
        }

        //criamos uma posição dotipo json $json['spouse'] para receber o $spouse. Sera enviada pelo json
        $json['spouse'] = $spouse;

        //=====================================================================================
        //CARREGANDO OS DADOS DE COMPANHIAS DO Adquirente SELECIONADO, ATRAVES DO POST JQUERY
        //=====================================================================================
        //verificamos se existe companies, se nao existir devolvemos 0
        if (empty($lessee)) {
            $companies = 0;
        } else {

            //atraves da relacao usuario - companhias que temos no modelo USER
            //retornaremos todas companhias do usuario
            //podemos filtrar os campos que queremos retornar
            $companies = $lessee->companies()->get([
                'id',
                'alias_name',
                'document_company',
            ]);
        }

        //criamos uma posição dotipo json $json['companies'] para receber o $companies. Sera enviada pelo response()->json($json);
        $json['companies'] = $companies;


        //=====================================================================================
        //retornarmos a variavel atraves de response pelo json
        return response()->json($json);
    }


    public function getDataProperty(Request $request)
    {
        //$request->property, o property, ta sendo recebido pelo post jquery
        //$.post(property.data('action'),{property: property.val()}, function(reponse){},'json');
        $property = Property::where('id', $request->property)->first();

        //se nao for recebido nenhum imovel
        if (empty($property)) {
            $property = null;
        }
        //se for selecionado um, criamos um array com todos seus dados
        else {
            $property = [
                'id' => $property->id,
                'sale_price' => $property->sale_price,
                'rent_price' => $property->rent_price,
                'tribute' => $property->tribute,
                'condominium' => $property->condominium,
            ];
        }

        //criamos uma posicao property, json para receber o array com os dados
        $json['property'] = $property;

        //retornamos atraves do response a variavel json 
        return response()->json($json);
    }
}
