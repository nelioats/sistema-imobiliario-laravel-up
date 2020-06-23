@extends('admin.master.master')

@section('content')
    


<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-search">Cadastrar Novo Contrato</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="">Contratos</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="" class="text-orange">Cadastrar Contrato</a></li>
                </ul>
            </nav>

            <button class="btn btn-green icon-search icon-notext ml-1 search_open"></button>
        </div>
    </header>

    
    @include('admin.contracts.filter')

    <div class="dash_content_app_box">

        <div class="nav">
            <ul class="nav_tabs">
                <li class="nav_tabs_item">
                    <a href="#parts" class="nav_tabs_item_link active">Das Partes</a>
                </li>
                <li class="nav_tabs_item">
                    <a href="#terms" class="nav_tabs_item_link">Termos</a>
                </li>
            </ul>

            <div class="nav_tabs_content">
                <div id="parts">
                    <form action="" method="post" class="app_form">

                        <div class="label_gc">
                            <span class="legend">Finalidade:</span>
                            <label class="label">
                                <input type="checkbox" name="sale"><span>Venda</span>
                            </label>

                            <label class="label">
                                <input type="checkbox" name="rent"><span>Locação</span>
                            </label>
                        </div>

                        <div class="app_collapse">
                            <div class="app_collapse_header mt-2 collapse">
                                <h3>Proprietário</h3>
                                <span class="icon-minus-circle icon-notext"></span>
                            </div>

                            <div class="app_collapse_content">
                                <div class="label_g2">
                                    <label class="label">
                                        <span class="legend">Proprietário:</span>
                                        <select class="select2" name="owner" data-action="{{ route('admin.contracts.getDataOwner')}}">
                                            <option value="0">Informe um Cliente</option>
                                            @foreach ($lessors->get() as $lessor)
                                                <option value="{{$lessor->id}}">{{$lessor->name}} ({{$lessor->document}})</option>
                                            @endforeach

                                            
                                        </select>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Conjuge Proprietário:</span>
                                        <select class="select2" name="owner_spouse">
                                            <option value="" selected>Não informado</option>
                                        </select>
                                    </label>
                                </div>

                                <label class="label">
                                    <span class="legend">Empresa:</span>
                                    <select class="select2" name="owner_company">
                                        <option value="" selected>Não informado</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="app_collapse">
                            <div class="app_collapse_header mt-2 collapse">
                                <h3>Adquirente</h3>
                                <span class="icon-minus-circle icon-notext"></span>
                            </div>

                            <div class="app_collapse_content">
                                <div class="label_g2">
                                    <label class="label">
                                        <span class="legend">Adquirente:</span>
                                         <select name="acquirer" class="select2" data-action="{{route('admin.contracts.getDataAquirer')}}">
                                            <option value="" selected>Informe um Cliente</option>
                                            @foreach ($lessees->get() as $lessee)
                                            <option value="{{$lessee->id}}">{{$lessee->name}} ({{$lessee->document}})</option>
                                        @endforeach
                                        </select>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Conjuge Adquirente:</span>
                                        <select class="select2" name="acquirer_spouse">
                                            <option value="" selected>Não informado</option>
                                        </select>
                                    </label>
                                </div>

                                <label class="label">
                                    <span class="legend">Empresa:</span>
                                    <select name="acquirer_company" class="select2">
                                        <option value="" selected>Não informado</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="app_collapse">
                            <div class="app_collapse_header mt-2 collapse">
                                <h3>Parâmetros do Contrato</h3>
                                <span class="icon-minus-circle icon-notext"></span>
                            </div>

                            <div class="app_collapse_content">
                                <label class="label">
                                    <span class="legend">Imóvel:</span>
                                <select name="property" class="select2" data-action="{{route('admin.contracts.getDataProperty')}}">
                                        <option value="">Não informado</option>
                                    </select>
                                </label>

                                <div class="label_g2">
                                    <label class="label">
                                        <span class="legend">Valor de Venda:</span>
                                        <input type="tel" name="sale_price" class="mask-money"
                                               placeholder="Valor de Venda" disabled/>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Valor de Locação:</span>
                                        <input type="text" name="rent_price" class="mask-money"
                                               placeholder="Valor de Locação" disabled/>
                                    </label>
                                </div>

                                <div class="label_g2">
                                    <label class="label">
                                        <span class="legend">IPTU:</span>
                                        <input type="text" name="tribute" class="mask-money" placeholder="IPTU"
                                               value=""/>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Condomínio:</span>
                                        <input type="text" name="condominium" class="mask-money"
                                               placeholder="Valor do Condomínio" value=""/>
                                    </label>
                                </div>

                                <div class="label_g2">
                                    <label class="label">
                                        <span class="legend">Dia de Vencimento:</span>
                                        <select name="due_date" class="select2">
                                            <option value="1">1º</option>
                                            <option value="2">2/mês</option>
                                            <option value="3">3/mês</option>
                                            <option value="4">4/mês</option>
                                            <option value="5">5/mês</option>
                                            <option value="6">6/mês</option>
                                            <option value="7">7/mês</option>
                                            <option value="8">8/mês</option>
                                            <option value="9">9/mês</option>
                                            <option value="10">10/mês</option>
                                            <option value="11">11/mês</option>
                                            <option value="12">12/mês</option>
                                            <option value="13">13/mês</option>
                                            <option value="14">14/mês</option>
                                            <option value="15">15/mês</option>
                                            <option value="16">16/mês</option>
                                            <option value="17">17/mês</option>
                                            <option value="18">18/mês</option>
                                            <option value="19">19/mês</option>
                                            <option value="20">20/mês</option>
                                            <option value="21">21/mês</option>
                                            <option value="22">22/mês</option>
                                            <option value="23">23/mês</option>
                                            <option value="24">24/mês</option>
                                            <option value="25">25/mês</option>
                                            <option value="26">26/mês</option>
                                            <option value="27">27/mês</option>
                                            <option value="28">28/mês</option>
                                        </select>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Prazo do Contrato (Em meses)</span>
                                        <select name="deadline" class="select2">
                                            <option value="12">12 meses</option>
                                            <option value="24">24 meses</option>
                                            <option value="36">36 meses</option>
                                            <option value="48">48 meses</option>
                                        </select>
                                    </label>
                                </div>

                                <label class="label">
                                    <span class="legend">Data de Início:</span>
                                    <input type="tel" name="start_at" class="mask-date" placeholder="Data de Início"
                                           value=""/>
                                </label>
                            </div>
                        </div>

                        <div class="text-right mt-2">
                            <button class="btn btn-large btn-green icon-check-square-o">Salvar Contrato</button>
                        </div>
                    </form>
                </div>

                <div id="terms" class="d-none">
                    <h3 class="mb-2">Termos</h3>

                    <textarea name="terms" cols="30" rows="10" class="mce"></textarea>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('js')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
    });

    $(function(){


        //iremos receber o valor onwer após sofre uma alteração
        //guardamos seu valor na variavel onwer
        //enviaremos uma ROTA atraves do POST para retornar com todos dados que quereos exibir na view
        //criamos a ROTA  no arquivo web.php
        //criamos a function no ContractController
        //no select aqui na view, criamos um atributo data-action para inserir a rota criada
        //criamos um meotodo POST no jquery recebendo a rota do data-action e  enviamos o id (atraves do user:owner.val() = essa variavel user que iremos receber no getDataOwner  ContractController) do usuairo seleionado 
        //nessa funcao recebermos uma resposta no formato json
        //para o contrlador foi enviado o user e receberemos os dados do usaurio atraves de response json 
        //para o POST funcionar temos que inserir o CSRF do laravel, caso nao, retronara o erro 419

        //=====================================================================================
        //PROPRIETARIO
        //=====================================================================================
        $('select[name="owner"]').change(function(){
            var owner = $(this);
            $.post(owner.data('action'),{user:owner.val()},function(response){
                
            //=====================================================================================
            //APRESENTANDO OS DADOS DO CONJUGE DO USAURIO SELECIONADO, ATRAVES DO RESPONSE RECEBIDO PELO POST
            //=====================================================================================
                //selecionamos o select owner_spouse e zeramos ele, para limpar qualuqer informação que tiver.
                $('select[name="owner_spouse"]').html('');
               
                //agora verificamos o response (spouse recebido pelo controlador pelo metodo POST), se retornou algo ou nao
                if(response.spouse){
                    //retornando algo, sendo verdadeiro, criamos um append para inseirir um option no select
                    // com valor 0 e texto NAO INFOMRAR,  para os clientes que nao querem infomar um conjuge
                    // com valor 1 e nome do conjuge , para os clientes que querem informar seu conjuge, response.spouse.spouse_name;(tudo recebido pelo meotdo post, do controlador)

                    $('select[name="owner_spouse"]').append($('<option>',{
                        value:0,
                        text: "Não Informar"
                    }))

                    $('select[name="owner_spouse"]').append($('<option>',{
                        value:1,
                        text: response.spouse.spouse_name +'('+response.spouse.spouse_document +')'
                    }))
                    //ele nao retornou nada, ou seja, o usuario nao tem conjuge
                }else{
                    
                    $('select[name="owner_spouse"]').append($('<option>',{
                        value:0,
                        text: "Não Informado"
                    }))
                }

            //=====================================================================================
            //APRESENTANDO OS DADOS DE COMPANIES DO USAURIO SELECIONADO, ATRAVES DO RESPONSE RECEBIDO PELO POST
            //=====================================================================================
                 $('select[name="owner_company"]').html('');
               
                //ja que o usuario pode ter varias companies, temos que receber uma colecao de objetos. no caso response.company.length
                if(response.companies.length){
    
                    //opcao padrao, caso o usuario noa queira informar
                   $('select[name="owner_company"]').append($('<option>',{
                       value:0,
                       text: "Não Informar"
                   }));

                   //como ele pode ter varias empresas, temos que percorrer o array com foreach
                   $.each(response.companies, function(key,value){
                        $('select[name="owner_company"]').append($('<option>',{
                        value:value.id, //esse id é recebido do reposnse ($json['companies'] = $companies;), quando definimos ele dentro do Contractcontroller
                        text: value.alias_name +' ('+value.document_company +')'
                    }));
                   });

               }else{
                   $('select[name="owner_company"]').append($('<option>',{
                       value:0,
                       text: "Não Informado"
                   }))
               }

            //=====================================================================================
            //APRESENTANDO OS DADOS DE PROPERTIES DO USAURIO SELECIONADO, ATRAVES DO RESPONSE RECEBIDO PELO POST
            //=====================================================================================
            $('select[name="property"]').html('');
               
               //ja que o usuario pode ter varias propriedades, temos que receber uma colecao de objetos. no caso response.propeties.length
               if(response.properties.length){
   
                   //opcao padrao, caso o usuario noa queira informar
                  $('select[name="property"]').append($('<option>',{
                      value:0,
                      text: "Não Informar"
                  }));

                  //como ele pode ter varias propriedades, temos que percorrer o array com foreach
                  $.each(response.properties, function(key,value){
                       $('select[name="property"]').append($('<option>',{
                       value:value.id, //esse id é recebido do reposnse ($json['properties'] = $properties;), quando definimos ele dentro do Contractcontroller
                       text: value.description //esse description é recebido do reposnse ($json['properties'] = $properties;), quando definimos ele dentro do Contractcontroller
                   }));
                  });  



              }else{
                  $('select[name="property"]').append($('<option>',{
                      value:0,
                      text: "Não Informado"
                  }))
              }







            },'json');
        });
        



        //=====================================================================================
        //ADQUIERENTE
        //=====================================================================================
        $('select[name="acquirer"]').change(function(){
            var acquirer = $(this);
            $.post(acquirer.data('action'),{user:acquirer.val()},function(response){

        //=====================================================================================
        //APRESENTANDO OS DADOS DO CONJUGE DO ADQUIERENTE SELECIONADO, ATRAVES DO RESPONSE RECEBIDO PELO POST
         //=====================================================================================
                //selecionamos o select owner_spouse e zeramos ele, para limpar qualuqer informação que tiver.
                $('select[name="acquirer_spouse"]').html('');
               
                //agora verificamos o response (spouse receido pelo controlador pelo metodo POST), se retornou algo ou nao
                if(response.spouse){
                    //retornando algo, sendo verdadeiro, criamos um append para inseirir um option no select
                    // com valor 0 e texto NAO INFOMRAR,  para os clientes que nao querem infomar um conjuge
                    // com valor 1 e nome do conjuge , para os clientes que querem informar seu conjuge, response.spouse.spouse_name;(tudo recebido pelo meotdo post, do controlador)

                    $('select[name="acquirer_spouse"]').append($('<option>',{
                        value:0,
                        text: "Não Informar"
                    }))

                    $('select[name="acquirer_spouse"]').append($('<option>',{
                        value:1,
                        text: response.spouse.spouse_name +'('+response.spouse.spouse_document +')'
                    }))
                    //ele nao retornou nada, ou seja, o usuario nao tem conjuge
                }else{
                    
                    $('select[name="acquirer_spouse"]').append($('<option>',{
                        value:0,
                        text: "Não Informado"
                    }))
                }


        //=====================================================================================
        //APRESENTANDO OS DADOS DE COMPANIES DO ADQUIERENTE SELECIONADO, ATRAVES DO RESPONSE RECEBIDO PELO POST
        //=====================================================================================
                 $('select[name="acquirer_company"]').html('');
               
                //ja que o usuario pode ter varias companies, temos que receber uma colecao de objetos. no caso response.company.length
                if(response.companies.length){
    
                    //opcao padrao, caso o usuario noa queira informar
                   $('select[name="acquirer_company"]').append($('<option>',{
                       value:0,
                       text: "Não Informar"
                   }));

                   //como ele pode ter varias empresas, temos que percorrer o array com foreach
                   $.each(response.companies, function(key,value){
                        $('select[name="acquirer_company"]').append($('<option>',{
                        value:value.id, //esse id é recebido do reposnse ($json['companies'] = $companies;), quando definimos ele dentro do Contractcontroller
                        text: value.alias_name +' ('+value.document_company +')'
                    }));
                   });

               }else{
                   $('select[name="acquirer_company"]').append($('<option>',{
                       value:0,
                       text: "Não Informado"
                   }))
               }



            },'json');
        });

        //=====================================================================================
        //APRESENTANDO OS DADOS DOS IMOVEIS SELECIONADOS ATRAVES DO RESPONSE RECEBIDO PELO POST
        //=====================================================================================
        //capturamos o select apos cada alteração
        $('select[name="property"]').change(function(){

            //guardamos o valor selecionado, no caso o value que foi alimentado no  //APRESENTANDO OS DADOS DE PROPERTIES DO USAURIO SELECIONADO, ATRAVES DO RESPONSE RECEBIDO PELO POST
            var property = $(this);
         

            //enviamos via POST pela rota do data-action do select, o valor selecionado. tudo atraves de reponse json
            $.post(property.data('action'),{property: property.val()}, function(reponse){

                //recebendo os valores do controlador
                //verificamos se reponse.property é diferente de null, ou seja, foi selecionado um imovel no select,
                // no caso o property foi definido no controlador $json['property'] = $property;
                if(reponse.property != null){

                    //sendo selecionado, apresentamos os valores do imovel selecionado, valores recebidos pelo reponse.property
                    $('input[name="sale_price"]').val(reponse.property.sale_price);
                    $('input[name="rent_price"]').val(reponse.property.rent_price);
                    $('input[name="tribute"]').val(reponse.property.tribute);
                    $('input[name="condominium"]').val(reponse.property.condominium);
                }
                else{
                    $('input[name="sale_price"]').val('0.00');
                    $('input[name="rent_price"]').val('0.00');
                    $('input[name="tribute"]').val('0.00');
                    $('input[name="condominium"]').val('0.00');
                }


            },'json');

        });


    });
</script>
    
@endsection