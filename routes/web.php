<?php

use Illuminate\Support\Facades\Route;


//=========================================================
//CONFIGURAÇÃO DO PROJETO
//==========================================================
//traduzir o laravel para portugues. 
//Acessar o link: https://github.com/caouecs/Laravel-lang. Baixar o pacote/copiar a pasta pt-BR/inserir na pasta resources/lang/pt-BR/configurar config/app.php=> locale e fallback_locale 
//alterar o timezone/ config/app.php /'timezone'=> America/Sao_Paulo

//=========================================================
//APPSERVICEPRIVIDER
//==========================================================
//Configuramos ele para que nosso banco seja configurado com UTF8 geneal ci que aceita emojis
//dentro de app/Providers/AppServiceProvider. Inserimos Schema::defaultStringLength(191);

//=========================================================
//ARQUIVO .ENV
//=========================================================
//disco de armazenamento: inserimos o comando FILESYSTEM_DRIVER para public, assim, inserimos toda nossa configuração no .env
//No arquivo APP_URL, será necessário mudar quando formos hospedar o sistema
//definirmos o nome correto do banco de dados

//=========================================================
//REMOVER AS ROTAS PADRAO
//=========================================================
//deletar welcome.blade dentro de views
//verificar quais sao as rotas: php artisan route:list
//comentar a rota que se encontra em routes/api.php

//ADEQUANDO O LAYOUT AO LARAVEL

//=========================================================
//CRIANDO AS ROTAS E SEUS GRUPOS
//=========================================================
//para o grupo de rotas. criamos o prefixo: admin/ Namespace: Admin/ Nome da rota: admin.(concatenação)

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    // rotas de login
    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    // rotas protegidas
    Route::group(['middleware' => ['auth']], function () {

        // dashboard home
        Route::get('home', 'AuthController@home')->name('home');

        // dashboard usuarios
        //
        Route::get('users/team', 'UserController@team')->name('users.team');
        Route::resource('users', 'UserController');

        //rotas para EMPRESA
        Route::resource('companies', 'CompanyController');

        //rotas para PROPERTY
        //rotas para check e remoção das imagens sem refresh na pagina com AJAX
        //post pois vai receber parametros
        Route::post('properties/image-set-cover', 'PropertyController@imageSetCover')->name('properties.imageSetCover');
        //delete, pois irá remover um registro
        Route::delete('properties/image-remove', 'PropertyController@imageRemove')->name('properties.imageRemove');

        Route::resource('properties', 'PropertyController');

        //rotas para CONTRACTS
        Route::post('contracts/get-data-owner', 'ContractController@getDataOwner')->name('contracts.getDataOwner');
        Route::post('contracts/get-data-acquirer', 'ContractController@getDataAdquirente')->name('contracts.getDataAquirer');
        Route::post('contracts/get-data-property', 'ContractController@getDataProperty')->name('contracts.getDataProperty');
        Route::resource('contracts', 'ContractController');
    });


    // logout
    Route::get('logout', 'AuthController@logout')->name('logout');
});

//=========================================================
//CRIAÇÃO DO CONTROLADOR ADMIN
//=========================================================
//php artisan make:controller Admin\\AuthController
//inserimos a Admn\\ para criar automaticamente o controlador dentro do diretorio Admin

//CONFIGURANDO O LARAVEL MIX
//verificar as versoes no arquivo package.json
//trabalhando no arquivo webpack.mix.js 
//setando todos os SCSS para o diretorio que irá ser salvo as folhas de estilos
//ex:  .sass('resources/views/admin/assets/scss/reset.scss','public/backend/assets/css/reset.css')
//criamos o diretorio /backend para nao criar conflito com o mesmo diretorio das rotas
//para baixar todas configuraçoes do node de conversão: npm install
//para criar excutar/copiar os arquivos para pasta public: npm run dev

//criando a rota para dasborad
// Route::get('home','AuthController@home')->name('home');

//=========================================================
//LOGIN COM AJAX = trabalhando com o arquivo login.js  ==== METODO USADO NA AULA QUE NAO FOI SEGUIDO
//O LOGIN FOI FEITO USANDO A BIBLIOTECA TOASTR(JS E CSS) E FEITO AS TRATATIVAS NO CONTROLADOR
//=========================================================
//criar a rota para o login
//necessario criar uma rota do tipo POST
//Route::post('login','AuthController@login')->name('login.do');
//o login ta sendo feito via ajax
//estamos editando o arquivo resources/views/admin/assets/js/login.js . Para que seja assistido em tempo de execução o NPM RUN, executamos o comando npm run watch
//será usado a migration padrao de usuario do laravel
//php artisan migrate
//atraves do login recebemos as requisiçoes e verificamos se é retornado o esperado com o ajax

//TRATANDO AS REQUISIÇOES DO LOGIN
//foi criado uma pasta App/Support/Message.php para servir como fabrica de mensanegs de erro/sucesso
//foi inserido no controllador(no arquivo raiz do controlado a inicialização do Message, atraves do seu construtor)



//=========================================================
//LOGOUT
//=========================================================
//criar a rota de logout
// Route::get('logout','AuthController@logout')->name('logout');
//criar o metodo logout no controlador

//=========================================================
//CRIAR ROTAS PROTEGIDAS
//=========================================================
//criar um grupo de rotas protegidas com o middleware => auth, do proprio laravel
//    Route::group(['middleware' => ['auth']], function () {});
//configurar o middleware/auth (app/http/middleware/Authenticate.php) para redirecionar para rota correta. No caso (admin.login) 

//=========================================================
//CONFIGURANDO O ACTIVE DO MENU NO SITE
//=========================================================
//foi criado um helper isActive.php (app/helpers/isActive.php)
//no helper verificamos qual rota esta sendo ativa e inserimos a classe(css) active
//necessario inserir no arquivo composer.json "autoload": {"psr-4": , o helper criado. "files": ["app/Helpers/isActive.php"
//rodar novamente a funcao composer dump-autoload para as alterações surtirem efeitos
// no arquivo master.blade.php/ ou no li-> do menu do html, onde inserimos o classe active, inserimos o helper {{isActive('nome da rota')}}.  

//=========================================================
//NO CASO DO USUARIO JA LOGADO
//=========================================================
//quando o usaurio estiver logado e por algum motivo acessar a pagina login. Teremos que retornar para pagina home, ja que o usuario ja tem uma sessao criada.
//para isso, verificamos se existe uma sessao criada, na funcao login do Authcontroller.
//utilizamos o comando Auth::check() === true


//=========================================================
//ARMAZENAR TANTO O IP COMO A DATA DO ULTIMO ACESSO DO USUARIO
//=========================================================
//para isso é necessário adicionar campos na tabela usuario
//criar uma migration para inserir as colunas na tabela usuario
//php artisan make:migration alter_users_table_add_control_login --table=users
//na migration inserimos informaçoes tanto no metodo up(criação de novos campos), como no meotdo down(para exclusao do id selecionado)
//php artisan migrate
//foi criado um metodo  public function autenticado() e dentro do metodo login é invocado o metodo. Para assim salvar o ip e a data


//==============================================================================================//
//++++++++++++++++++++++ FIM DO LOGIN NA PAGINA ADMIN(LAYOUT LIMPO) ++++++++++++++++++++++++++++//
//==============================================================================================//


//=========================================================
//CRIAÇÃO DO CONTROLADOR e DA ROTA DO USAURIO
//=========================================================
//php artisan make:controller Admin\\UserController --resource
//--resource para gerar todas os metodos de crud
//a rota será criada dentro do grupo de rotas protegidas admin
//Route::resource('users','UserController');
//para rota ja etao definidas a rota admin/ e o name admin/
//php artisan route:list

//=========================================================
//CONFIGURAR AS ROTAS COM SEUS METODOS E VIEWS
//=========================================================
//No metodo index, chamar a view admin.users.index
//configurar a classe active no restante do menu na master.blade
//configurar as views com seus extends(no caso a index extendendo da master)
//criamos a rota team. DEvido ela ser uma rota personalizada(que nao foi criada no Route::resource('users','UserController')
//a rota team tem que ser criada acima da rota Route::resource('users','UserController');
//No metodo team, chamar a view admin.users.team
//No metodo create, chamar a view admin.users.create

//=========================================================
//CADASTRO DE USUÁRIO - FORMREQUEST / VALIDATION(tradução)
//=========================================================
//dentro da visao create.blade.php, configurar o action do form com a rota {{ route('admin.users.store')}}
//temos que tratar os dados que estamos recebendo. Para isso, criamos um FORM REQUEST
//php artisan make:request Admin\\User
//dentro do controlador UserController, no metodo STORE, teremos que passar o request User que criamos
//para que nao entre em conflito o request USER  e o modelo USER, criamos um alias no => use App\Http\Requests\Admin\User as UserRequest;
//dentro do \Requests\Admin\User no metodo authorize(), podemos inserir no return um Auth::check(); isso é mais uma validação se o usuário tá logado.
//para isso necessitmos chamar a classe auth => use Illuminate\Support\Facades\Auth;
//dentro do \Requests\Admin\User no metodo rules(). Vamos inserir as regras dos campos do formulário;
//se as regras nao estiverem de acordo ao preenchumento do formulario, o form nao será executado
//dentro do arquivo create.blade.php, acima do form, inserimos um for apresentando os erros
//==================================================================================
//CRIANDO COMPONENTE PARA PADRONIZAR O COMPORTAMENTO DAS MENSAGENS/////////////////
//verificar documentação do laravel 7 = nao foi feito com componente
//==================================================================================
//para que os dados fiquem salvos mesmo após submetendo o formulário. É só inserir o value="{{old('name do input')}}"
//inserimos todas as regras no form request(User)
//para traduzir os nomes dos nossos campo para serem visualizados nas mensagens de erro. TEmos que acessar resourse/lang/pt-BR/validation.php . Nele iremos inserir o campo e sua tradução 'document' => 'CPF'
//para os atributos dentro do in  'civil_status' => 'required|in:married,separated,single,divorced,widower',. Necessario criar outro array com os values
//no formrequest, quando inserimos o atributo unique, o laravel verifica se é um valor unico no banco // 'document' => 'required|min:11|max:14|unique:users' (unico na tabela users)


//==================================================================================
//CADASTRO DE USUÁRIO - VALIDANDO OS DADOS COM O METODO FILLABLE NO MODELO
//==================================================================================
//no modelo users, inserimos todos os campos no metodo fillable.
//dentro do controlador $user = new User(); user->fill($request->all()); para testar as validacoes do metodo fillable
//dentro do modelo users, para se criar os filtros, onde irão converter os dados para DADOS COMPATIVEIS COM O BANCO DE DADOS.
//temos que criar metodos para cada atributo, definindo sua regras de negocio. Ex: (é obrigaatorio o uso da palavra set + nome + Attribute)
// public function setLessorAttribute($value){
//     $this->attributes['lessor'] = ($value === true || $value === 'on' ? 1 : 0);
// }


//==================================================================================
//CADASTRO DE USUÁRIO - PERSISTIR OS DADOS NO BANCO
//==================================================================================
//criar a migration para inserir as colunas na tabela usuarios
//php artisan make:migration alter_users_table --table=users
//definir os campos da tabela na migration
//executar a migration
//php artisan migration
// no controlado, utlizar o metodo $userCreate = User::create($request->all()) para criar o ususario no banco
//caso erre algum nome na migrtion. Corrigir a migration e executar: php artisan migrate:refresh


//==================================================================================
//LISTAGEM DE USUÁRIO - 
//==================================================================================
//No metodo index, do controlador UserController, listar todos usuarios e enviar para view
//na view, como metodo foreach do blade chamar a coleção recebida pela view

//==================================================================================
//EDIÇÃO DE USUÁRIO - 
//==================================================================================
//dentro da view admin/users/index, no campo nome, criamos um link com a rota: {{route('admin.users.edit',['user'=>$user->id])}}. para enviar o id do usuario que ir´sofrer a edição
//no metodo edit do controlador UserController, recebemos o id, filtramos com where, e enviamos para view admin/users/edit
//*********lembrete : first para receber um registro | get para receber uma coleção  ******************/
//a view edit é uma cópia da view create, no form , teremos que alterar a rota de route('admin.users.store') para route('admin.users.update')
//inserir abaixo do @csrf a tag  @method('PUT')
//na view edit, no campo value, tem q deixar o old e receber o valor fornecido pelo banco. como o metdo novo do php value="{{old('name') ?? $user->name}}"


//==================================================================================
//RECEBENDO DADOS DO USUÁRIO - FORMATANDO OS DADOS PARA APRESENTAÇÃO - NO MODELO
//==================================================================================
//Durante a inserção dos dados, no modelo usamos o set. Para receber os dados e formata-los, usamos o get
//No metodo update do controlador UserController, usamos nosso formrequest criado(UserRequest)
//para que os campos de checkbox nao fiquem com campos vazios, caso seja altrado pelo usuario. Inserimos os meotodos set do modelo USER

//==================================================================================
// UPLOAD DE ARQUIVO DO USUARIO NA EDIÇÃO DO USUARIO
//==================================================================================
// criar o link da pasta storage , na pasta public com o seguinte comando:
//php artisan storage:link
//devido a coluna 'cover' que ira armazenar o caminho para imagem nao estar criada. E para nao perder a infomração ja registrada no banco. Inserimos a coluna na migration (só para registro) e adicionamos a coluna de forma manula no banco de dados.

//Para que seja salva somente uma imagem por usuario.
//Para verificar se já existe alguma imagem por usuario.
//É necessário que seja deletada tanto imagem do storage como o diretorio do banco.

//criando o diretorio onde será armazenado a imagem
// Verificar se é diferente de vazio, se sim, salva a imagem.

//==================================================================================
// UPLOAD DE ARQUIVO DO USUARIO NA CRIAÇÃO DO USUARIO
//==================================================================================
//enviamos a mesma funcao usada na edição, mudando o nome da variavel
// if(!empty($request->file('cover'))){
//     //no banco dentro da coluna cover = $request->file('cover') = arquivo | ->store('user') = diretorio
//     $user->cover = $request->file('cover')->store('user');
// }

//==================================================================================
// APRESENTAR AS IMAGENS DO TIME NA VIEW TEAM
//==================================================================================
//carregar todos usuarios administradores, ou seja, todos que tem o valor 1, no banco
//pra exibir as imagens, vamos no modelo User e inserios um get para imagem no STORAGE
//para cortar as imagens para se enquadrar no formato circulo, usamos o pluggin do robson CROPPER (necessario inserir o arquivo no app/Support e executar o comando   ===>  composer require coffeecode/cropper)
//dentro de Cropper inserimos o metodo flusher
//dentro do modelo User, no getUrlCoverAttribute,  modificamos para receber o metodo Cropper
//devido o cropper foi criado uma imagem no cache, como miniatura e caso seja atualiada a imagem é necessario apagar o cache com o flush no contralador na funcao upload

//==================================================================================
// DANDO CONDIÇÃO CASO SEJA SELCIONADO AS OPCÇOES CASADO OU SEPARADO (PAGINA EDIT E CREATE)
// NESSE CASO NÃO TERÁ QUE APARECER AS OPÇOES DO CONJUGE - FEITO COM JQUERY JS
//==================================================================================
//criamos um script no final da pagina edit. Nele atraves de jquery identificamos se o usuario selecionou casado ou solteiro. Caso nao tenha selecionado essas dusa opções, iremos deifinir a div do conjuge com disabled
//para que seja chamado ao executar a pagina, foi criado uma funcao e chamamos essa funcao todo momento que é carregada a pagina
//para que o script seja executdo dtoda ve que for alterado, será necessario criar uma funcao change e chamar ela todo momento que algo for mudado no select civil_status
//para que esse SCRIPT tmb seja executado na pagina NAS PAGINAS CREATE E EDIT, removemos ele para nosso script.js

//==================================================================================
// PARA INSERIR A EXCEÇÃO NO MOMENTO DA EDIÇÃO DE CAMPOS UNIQUE(EMAIL E CPF) PAGINA EDIT
//==================================================================================
// a validação unique  funcionava antes somente no email, devido a mascara do cpf que empre alterava o valor do cpf
// no formRequest temos uma funcção all($keys = null) para receber todos valores dos inputs
//na funcao validateFields,  inserimos no campos cpf, um valor formatodo removendo todos os pontos e traços. E retornamos seu valor para $inputs
//*******************INFORMAOCAO DICA************************* */
//no modelo, temos o setDocumentAttribute, que remove todos os pontos e traços do cpf para ser salvo somente os numeros
//o formRequest nao verificava antes,(só verificava o email) prq no momento do formRquest verificar o cpf que é um campo UNIQUE, ele vem com ponto e traços,diferente do valor no banco. Por isso passava e bloqueava somente no email
//agora com a verificação no formRequest, removendo os pontos e traços antes de ter a validação, teremos o bloqueio do cpf
//******************************************** */
//na funcção RULES DO FORMREQUEST, iremos inserir uma exceção para document e email(exceção pois o proprio usuario nao precisa alterar seu cpf)
//agora precisamos enviar o id pelo form da pagina edit, PARA SER RECEBIDO NO FORMREQUEST



//===============================================================================================================
//===============================================================================================================
// INICIANDO O MODELO -> EMPRESA
//===============================================================================================================
//===============================================================================================================
//criar o modelo junto com a migration: php artisan make:model Company -m
//criar o controlador(podemos ter criado o controlador junto com o modelo, mas criamos separado para direcionar para um diretorio Admin\)
//php artisan make:controller Admin\\CompanyController --resource
//criar as rotas dentro do group admin Route::resource('companies','CompanyController');
//definindo as rotas com as views
//para ativar o menu ativo é necessário chamar na master o isActive('admin.companies')
//definindo as atriutos da migration
//definimos o campo (user) como unsignedInterger, pois é um campo assinado que nao aceita numero negativos(no caso é o id do usuario)
//inserimos esse campo como chave estrangeira que faz referencia para tabela usuarios. ($table->foreign('users')->references('id')->on('users')->onDelete('CASCADE'))
// rodar as mgrations = php artisan migrate   
//no modelo definir os campos com metodo fillable
//para criar as regras dos inputs, precisamos criar nosso Request
//php artisan make:request Admin\\Company
//importar o Auth::check(); use Illuminate\Support\Facades\Auth;
//inseiri no controlador nosso Request, como tem o mesmo nome do modelo, criamos um alias, no USE da classe
//inserir as regras no request
//inserir o comanso old no form da pagina create para que persista os dados
//inserimos no validation(resource/lang) as traduçoes para os novos campos do formulario(empresa). No caso social_name, alias_name... 
//==================================================================================
// TRATANDO OS DADOS DA EMPRESA PARA SALVAR NO BANCO - SET
//==================================================================================
//No modelo Company, iremos inserir as funcões SET
//comecamos com o SET do setDocumentCompanyAttribute (lembrando a obrigatoriedade da nomecaltura - setXXXAttribute) utiliando a funcao clearField como helper
//ja com registro de empresas no banco, no controlador, no metodo index, listamos todas as empresas
//para listar o nome do usuario ou todos os campos, é necessario configurar a relação entre as tabelas.
//==================================================================================
// CONFIGURANDO AS RELAÇÕES ENTRE AS TABELAS (RELACAO FEITA NA TABELA EMPRESA)
//==================================================================================
//No modelo User, criamos uma funcao companies que retorna um metodo hasMany() (um para muitos - um usuario para muitas empresas)
//No  modelo Company, criamos uma funcao user quer retorna um metodo belongsTo() (muitos para um) - varias empresas para um usuario)
//para listar um usuario atraves da companies(no caso na pagina index companies) $company->user()->first()->atributos do usuario (user - nome do metodo criado dentro do modelo/ first para receber somente o primeiro, pode ter varios)
//==================================================================================
// TRABALHANDO COM A PAGINA DE EDIÇÃO DE EMPRESA
//==================================================================================
//no controlador, na function edit, selecionamos o id enviado pela index e retornamos para view edit.blade.php com a companhia do id selecionado
//fazemos uma copia da pagina create para edit
//nos campos value, alem do old ?? carregamos os dados do usuario ja existente
//no action do form, mudamos para update a rota e enviamos o id que será alterado
//inserimos o verbo PUT, no form com ajuda do blade  @method('PUT')
//NO METODO DE UPDATE
//no controlador update, usamos nosso request
//==================================================================================
// RECEBENDO OS DADOS DO BANCO FORMATADOS - GET
//==================================================================================
//no modelo company, usamos o metodo get e formatamos o valor do cnpj para ser apresentado na pagina index
///==================================================================================
// LISTANDO OS USAURIOS NO SELECT NA PAGINA EDIÇÃO E CRIAÇÃO DA EMPRESA
//==================================================================================
//dentro do Companycontroller na funcao edit, chamamos o modelo User e damos um get (usamos o orderBy para facilitar na pesquisa)
//dentro da pagina edit de companies no select, criamos um foreach para percorrer os usuarios
//para deixar ja o dono da empresa selecionado, inserimos uma ternaria {{$user->id === $company->user ? 'selected': ''}} 
//==================================================================================
// LISTANDO AS EMPRESAS DENTRO DA PAGINA DE EDIÇÃO DO USUARIO
//==================================================================================
//na pagina de edição de usuario(route(admin.users.edit)) na parte de empresas, vamos listar as empresas  {{-- se existe compania para esse usuario(metodo companies criado atraves da relação que criamos no modelo user)
// no botao criar empresa, definimos a route create empresas e enviamos o id do usuario
//na pagina create, temos que carregar a pagina ja com o select selecionado pelo usuario, para isso:
//no contrador do company, no metodo create inserimos o request (para receber o id enviada pelo botao criar empresa). Nele verificamos se ja existe um id ou carregamos todos usuarios
//no metodo create retornamos um unico usuario no caso se for uma criação de empresa atraves da pagina do usuario
//no metodo create retornamos um varios usuario no caso se for uma criação de empresa atraves da pagina criar empresas


//===============================================================================================================
//===============================================================================================================
// INICIANDO O MODELO -> IMOVEIS
//===============================================================================================================
//===============================================================================================================
//php artisan make:model Property -m (criar model e migration)
//php artisan make:controller Admin\\PropertyController --resource
//criamos as rotas no arquivo web.php 
//configurando os links na view admin.master.master.blade.php ({{ isActive('admin.properties') }})
//definindo as views dentro do controlador
//na view create, inserir o @csrf no form | route(create)
//no metodo store do controlador. Instanciar o modelo Property e usar metodo fill
//no modelo, inserir o metodo protected $fillable = [ e todos os campos recebidos do formulário ];
//configurar a migration CreatePropertiesTable
//rodar o comando php artisan migrate
//SEMPRE ACONTECE ERRO NO MOMENTO DE CRIAR A RELAÇAO DEVIDO O CURSO TABALHAR COM LARAVEL 5.3 QUE USA INT NO ID, E ESTOU USANDO O LARAVEL 7.0 ONDE USA BIGINT NO ID
//criar o formRequest de imoveis - php artisan make:request Admin\\Property
//lembrando de inserir Auth::check(); na funcao authorize
//inserir o Property request na funcao create e update do controlador
//inserir o campo old{{}} no formulario create para fazer a persistencia dos dados
//inserir bloco de mensagens de erros ao submeter o formulario no na pagina create
//apos todas regras criadas
//trabalhar na camada de Modelo, para configurar os SET(tratar os campos para salvar no banco de dados) e os GET(obter de forma certa os campos do banco de dados) das atributos necessarios
//apos testar todos os campos, no controlador PropertyController na funcao store, chamamos o metodo create do modelo Property colocando todos sem request all para serem salvos no banco
//apos salvar no banco, direcionar para route de edição com id da criação e a mensagem de salva com sucesso
//na metodo edit no controlador PropertyController, pesquisamos pelo id recebido e direcionamos para view edit com o id recebido
//na view edit, no meotod old, adicionamos outra consição para ´persistir os dados, agora com os dados vindo do banco
//no modelo Property, criamos os metodos GET para formatar o valor recebdo no banco
//ATUALIZANDO
//no view edit, modificamos sua rota para update e enviamos o id . Tambem inserimos o metodo put no formulario
//no PropertyController no metodo update,selecionamos o id e chamamos o metodo save
//no caso dos checkbox, caso eles sejam alterados, nao consguimos atualizar eles no banco,pois eles nao sao enviados para banco quando nao sao selecionaods, para isso chamamos novamnete os metodos SET deles dentro do metodo update do controlador, para definir o valor com 0 nesses casos
//listar os usuarios nas views properties para esolha do usuario
//no metodo edit e create de PropertyController. criamos uma variavel user para receber todos usuarios do modelo User e com orderBy 
//==================================================================================
// LISTANDO OS IMOVEIS DENTRO DA PAGINA DE EDIÇÃO DO USUARIO
//==================================================================================
//criamos uma relação dentro do modelo User, com o modelo Property =  public function properties() hasMany - um para muitos
//criamos uma relação dentro do modelo Property, com o modelo User =  public function user() belongsTo - muitos para um
//com a relação criada, agora podemos dentro do usuario (na view edit) chamar todos os imoveis que estao vinculados ao seu id - atraves da instancia (modelo) do usuario chamamos o meotodo properties()->get() para listar todos os imoveis
//==================================================================================
// LISTANDO TODOS IMOVEIS DENTRO DE IMOVEIS - VER TODOS
//==================================================================================
//pegamos todo o bloco que apresenta os imoveis dentro do usuario e colar em properties.index
//no PropertyController no metodo index, instanciamos o modelo Property e envimos todos imoveis pela view
//==================================================================================
// CARREGANDO AS IMAGENS DOS IMOVEIS
//==================================================================================
//usamos um script(no final da pagina edit) para exibir um preview de todas imagens carregas


//===============================================================================================================
//===============================================================================================================
// CRIAREMOS UM MODELO, MIGRATION, CONTROLADOR : EXCLUSIVAMENTE PARA SALVAR IMAGENS CARREGADAS NOS IMOVEIS NAS VIEWS EDIT E CREATE
//===============================================================================================================
//===============================================================================================================
//php artisan make:model PropertyImage -m
//php artisan migrate (criamos a relação no banco, deu erro no laravel)
// caso esqueca de fazer algo na migration php artisan migrate:rollback --step=1 (retorna uma migracao)
//no modelo preencher o protected $fillable = [];
//dentro do controlador PropertyController no metodo update, Vamos inserir uma condiçao para verifivar se existe imagens no regquest-allFiles()
//se existir imagens, criamos um for para percorrer o array de imagens e para cada imagem, instanciamos o modelo(objeto) PropertyImage para salvar cada imagem em uma linha no banco de dados. E na asta storage dando o path com id property na frene 
//para exibir as imagens salvas no banco na view  properties.edit teremos que criar um relacionammento entre as imagens e os imovies(properties)
//como cada imovel possui uma imagem ou varias. Criaremos uma relação hasMany no Modelo Property
//com relação criada, criamos um foreach, para apresentar todas imagens. Pegando somente o path da imagem não seraá apresento. PAra isso criamos um metodo GET dentro do modelo PropertyImage onde retornará a URL das imagens, utiliando o helper Cropper, (plugin do robson que pode ser substituido pelo thbmbanis do bootstrap)

//==================================================================================
// DELETANDO AS IMAGENS COM REQUISIÇÃO AJAX SEM REFRESH NA PAGINA
//==================================================================================
// criamos 2 links de check e delete
// para cada link criamos uma rota
// criamos seus controladores(com resquest)
// vericamos as rotas php artisan route:list
// inserimos javascript:void(0) no href para não causar nenhuma ação de link 
// criamos uma tag data-action para definir as rotas de cada botao e enviar o id de cada imagem
// comecando com javascript
// criamos uma classe, image-set-cover ,em cada botao apenas para capturarmos no javascript
// no javascript pegamos o evento click dessa atraves dessa classe
// event.preventDefault(); para remover evento padrao dela
// pagamos a propria classe com o let button = $(this);
// enviamos atraves de POST a nossa requisição que esta em data-action('');
//  $.post(button.data('action'),{},function(response){
//              alert(response);
//     },'json');
//para a requisição delete temos: 
//     $('.image-remove').click(function(event){
//             event.preventDefault();

//         let button = $(this);
//         $.ajax({
//             url:button.data('action'),
//             type:'DELETE',
//             dataType:'json',
//             success: function(response){
//                 alert(response);
//             }
//         })

//     });
// atraves do PHP será capaz de receber a variavel response. No caso colocamos no PropertyController imageSetCover e imageRemove
// Devido o uso do POST no laravel é necessario o crsfToken
// -nas metas do cabcalho do site:
//     <meta name="csrf-token" content="{{ csrf_token() }}">
// -no javscript:
//       $.ajaxSetup({
//                 headers: {
//                     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
//                 }
//         });
//Em PropertyController imageSetCover, pegamos o id da imagem selecionada 
//Depois pegamos todas as imagens do imovel e definimos seu cover como null
//Em seguida pegamos a imagem selecionada e definimos seu cover como true
//criamos uma variavel json sucess e retornamos ela
// voltando para o javascript, dentro da function post criamos uma condição, checando se retornou true, caso sim, removemos todo btn-green das imagens e adidionamos apenas na imagem que recebeu o click
//Em PropertyController imageRemove, pegamos o id da imagem selecionada
//deletamos ela da storage
//limpamos o cache dela do cropper
//deletamos a imagem
//criamos uma variavel json sucess e retornamos ela
//voltando para o javascript, dentro da function delete, criamos uma condição para verificar se retornou true, caso sim, pegamos a classe(div) que contem o bloco da imagem que foi selecionda para ser deletada, adicionamos um fadeout e inserimos um this.remove;
//===========================================================
//com a imagem principal ja com o cover como 1, nas views , admin.properties.index  |  admin.users.edit  iremos apresentar a imagem principal(a q tem o cover como 1)
//criamos um metodo dentro do modelo Property para retornar a imagem que tem o cover 1.
//dentro desse metodo criamos outras condiçoes para imoveis que nao tem a imagem setada como principal e para imoveis que nem tem imagens e por fim, retornamos a url da imagem



//===============================================================================================================
//===============================================================================================================
// INICIANDO O MODELO -> CONTRATO
//===============================================================================================================
//===============================================================================================================
//criar o model junto com a migration
//php artisan make:model Contract -m    
//criar uma rota resource no documento web.php
//criar o controlador
//php artisan make:controller Admin\\ContractController --resource 
//linkar no controlador a view index
//personlizar a index
//linkar no controlador a view create
//personlizar a view create
//preencher a migration
//php artisan migrate
//necessario parametrizar nosso modelo com o metodo FILLABLE e os atributos
//=================
//no modelo Users, criaremos um SCOPE ( scopeLessors e scopeLessees)para retornar os locatarios(lessee) e os locadores(lessors)
//atraves do metodo create do ContractController recebemos esse SCOPE e enviamos para view CREATE
//==========================================
//CRIANDO OS GATILHOS COM JQUERY PARA CARREGAR AS INFORMAÇÕES DO PROPRIETARIO SELECIONADO SEM REFRESH
//==========================================
// as informaçoes estao na view contracs.create.blade e no metodo getDataOwner do ContractController (carregar as infomraçoes do conjuge e companies do proprietario sem refresh)
// para o adquirente , carregar as informaçoes sem refresh, utilizamos os mesmos procedimentos,
//criamos a rota 
//criamos o controlador
//criamos o data-action no formulario da view, para definir a rota
//criamos o gatilho POST com o jquey na view, ira chamar o data-action, que será direcionado para contralor onde esse ira retornar um REPONSE json com os dados para apresentar.
//no jquey tratamos esse RESPONSE, para ser apresentado na view.
// para os properties , carregar as informaçoes sem refresh, utilizamos os mesmos procedimentos das companies;
//=============================================
//para apresentar os valores dos contratos sem refresh apos selecionar um imovel:
//criamos uma rota: Route::post('contracts/get-data-property', 'ContractController@getDataProperty')->name('contracts.getDataProperty');
//criamos a function para rota
//na view no select do imovel, inserimos um data-action com a rota criada
//na view, no jquery, selecionamos o select e a cada alteração sua, criamos uma variavel para receber o valor selecionado e enviamos esse valor atraves do post e a rota definida no data-action para o contraldor
//o controlaor trata a valor recebido e retorna os dados do imovel selecionado para view
//na view no jquery, sera recebido os valores do imovel e será apresentado nos campos apropriados
//=============================================
//configirando o checkbox vendas e aluguel, em todo sistema para desativar os inputs caso seja selecionado o checkbox
//sendo em todo sistema, sera configurado no resourses/views/admin/assets/js/scripts.js 
//apos a atualização nm run dev
//=============================================
//criando as regras para modelo Contract
//=============================================
//criando request
//php artisan make:request Admin\\Contract
//no request inserir
//check para veriricar usuarios autentcados
//regras para os inputs
//apos as regras, inserir bloc de mensagens de erro na view do form e criar rota no form action
//=============================================
//persistencia dos dados do Contract apos erro no request 
//=============================================
//no controlador, no metodo store, deinir nosso Request que criamos
//no form, inserir os campos old no formulario para pesrsistir os dados
//persisitir tmb os camapos gatilhos js
//=============================================
//persistencia dos dados do Contract no banco
//=============================================
//no metodo create
//instanciamos um objeto do tipo contract
//usamos o metodo fill para verificar como os campos q irao ser salvos no banco. Damos um dd na varival que recebe o fill para verificar os campos
//os campos temos que transforma-los de acordo com os formatos dos campo definidos no banco de dados. Ex data-date, dinhiero
//no modelo iremos criar os metodos set, para converter os campos para os formatos adequados no banco
//apos todos os testes, criaremos o metodo create no metodo store do controlador
//redirecionamos com redirect para videw edit enviando o id
//=============================================
//edição do formulário
//=============================================
//criar uma copia da view create e nomear para edit
//no controlador edit, ciramos uma variavel contract que ira receber o id, enviado pelo redirect acima
//retornamos para view edit
//na view edit, alem dos atributos olds, iremos preencher os campos com os dados vindos do banco
//apos persisiti todos valores dos campos no formulario
//preparamos a rota para update enviando o id no fomrulario, definindo o metodo como PUT
//no medtodo update do controlador, atualizamos o contrato
//=============================================
//listagem dos contratos - index
//=============================================
//criar relacionamento dentro do modelo. Relacionamento muitos(contratos) para um(usuario) para devolver o usaurio na pagina index
//no metodo index do contrlador, criamos uma variavel com todos contratos , juntamento com o relacionamento e enviamos para view index
//na view index, chamamos o realcionamento hasOne para listar todos contratos e seus usuarios
//repetimos esses mesmos passos para o acquirer
//=============================================
//configuração do termo de contrato
//=============================================
// na view edit, no campo terms, apresentamos um metodo $contract->terms() que é configurado diretamente no modelo contract
//no modelo contract, no metodo terms() configuramos toda apresentação do formulario




//=============================================
//adicionando a coluna status na tabela properties e contracts.
// Vai servir para infomar qual imovel ta disponivel ou nao. (na taela um boolean)
// Par o contrato, que pode ter varios status(pendente- ativo - cancelado - expiparado) ou seja vai ser uma string na tabela
//=============================================
//criamos uma migration para add o campo
//php artisan make:migration alter_properties_table_add_status --table=properties
//php artisan make:migration alter_contracts_table_add_status --table=contracts
//inserir no fillable dos modelos o novo campo com seus set e get
//na view edit e create de properties, inserimos um select para escolha do status (disponivel ou indisponivel) 
//na view edit e create de contract, inserimos um select para escolha do status (ativo - pendente - cancelado) 
//no contractController, no metodo UPDATE, iremos informar se o imovel(property) ta disponivel ou nao


//===============================================================================================================
//===============================================================================================================
// ALIMENTADO A DASHBORAD
//===============================================================================================================
//===============================================================================================================
//no controlador AuthController o metodo home, iremos evniar todas os dados atraves do modelos


//===============================================================================================================
//===============================================================================================================
// CHECANDO O SISTEMA  E FAZENDO CORREÇOES
//===============================================================================================================
//===============================================================================================================
//INSERINDO A IMAGEM NO PERFIL DA PAGINA MASTER
//foi inserida o codigo php diretamente nessa pagina, pois ela sera chamada pelas outras

//ACEITANDO SOMENTE IMAGENS NO CADASTRO DO USUARIO
//dentro do request user, inserir o campo 'cover' => 'image' O proprio laravel so aceitara documento tipo imagem 

//ACEITANDO SOMENTE IMAGENS NO CADASTRO DE IMOVEIS
//antes de fazer o upload no metodo upload do controlador PropertyController, inserimos uma checagem verificando se os arquivos sao do tipo imagem



//===============================================================================================================
//===============================================================================================================
//===============================================================================================================
//===============================================================================================================
// WEB - DESENVOLVENDO LAYAOUT WEB
//===============================================================================================================
//===============================================================================================================

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    //Pagina inicial
    Route::get('/', 'WebController@home')->name('home');

    //Pagina de contato
    Route::get('/contato', 'WebController@contato')->name('contact');

    //Pagina de Locação
    Route::get('/quero-alugar', 'WebController@rent')->name('rent');

    //Pagina de compra
    Route::get('/quero-comprar', 'WebController@buy')->name('buy');

    //
    Route::match(['post', 'get'], '/filtro', 'WebController@filter')->name('filter');

    //Paginas especificas de imoveis para venda e alugar
    Route::get('/quero-comprar/{slug}', 'WebController@buyProperty')->name('buyProperty');
    Route::get('/quero-alugar/{slug}', 'WebController@rentProperty')->name('rentProperty');

    //Pagina experiencias
    Route::get('/experiencias', 'WebController@experience')->name('experience');

    //Paginas especificas de experiencias
    Route::get('/experiencias/{slug}', 'WebController@experienceCategory')->name('experienceCategory');

    //pagina destaque
    Route::get('/destaque', 'WebController@spotlight')->name('spotlight');

    //enviando email
    Route::post('/contato/sendEmail', 'WebController@sendEmail')->name('sendEmail');
    //retornando view de sucesso do email
    Route::get('/contato/sucesso', 'WebController@sendEmailSuccess')->name('sendEmailSuccess');
});

//php artisan make:controller Web\\WebController

//=========================================================
//CONFIGURANDO AS INFORMAÇÕES NO ADMIN/PROPERTIES PARA SEREM APRESENTADAS NA WEB
//=========================================================
//sera criado uma migration adicionando campos na tabela properties
//php artisan make:migration alter_properties_table_add_title_slug_headline_experience --table=prperties
//nao vai funcionar o comando php artisan migrate, erro anterior
//acrecentar os campos nas visoes edit e create de properties
//será criado no modelo Property, um metodo setSlug, que irá criar a rul amigavel do imovel, com o srtSlug no nome e id
//esse metodo será chamado no propertyController nos metodos edit e creat, apos o save do edit e apos o create de create

//será adicionado mais dois scopes, no model Property, retornanado imoveis para venda e locaçao
//no WebController, no metodo home, iremos receber os imoveis para venda ou locação atraves da concatenação de scopes do model Propery, 
//na visao web.home recebemos os imoveis de venda e locacao e exibimos atraves do loop

//para criar um link para cada imovel, no link das imagens para venda e locacao, definimos as rotas novas
// Route::get('/quero-comprar/{slug}', 'WebController@buyProperty')->name('buyProperty'); no link da imagem enviamos a rota/slugs
// Route::get('/quero-alugar/{slug}', 'WebController@buyProperty')->name('buyProperty'); no link da imagem enviamos a rota/slugs
//criamos um metodo no webController para receber a informação do slug

//=========================================================
//CONFIGURANDO AS OS FILTROS DA PAGIAN HOME COM JS
//=========================================================
//inserir data-action no select da view home
//criar novo agrupamento de rotas, pois podemos preceisar deles depois, no cado de api


Route::group(['prefix' => 'component', 'namespace' => 'Web', 'as' => 'component.'], function () {

    Route::post('main-filter/search', 'FilterController@search')->name('main-filter.search');
    Route::post('main-filter/category', 'FilterController@category')->name('main-filter.category');
    Route::post('main-filter/type', 'FilterController@type')->name('main-filter.type');
    Route::post('main-filter/neighborhood', 'FilterController@neighborhood')->name('main-filter.neighborhood');
    Route::post('main-filter/bedrooms', 'FilterController@bedrooms')->name('main-filter.bedrooms');
    Route::post('main-filter/suites', 'FilterController@suites')->name('main-filter.suites');
    Route::post('main-filter/bathrooms', 'FilterController@bathrooms')->name('main-filter.bathrooms');
    Route::post('main-filter/garage', 'FilterController@garage')->name('main-filter.garage');
    Route::post('main-filter/price-base', 'FilterController@priceBase')->name('main-filter.priceBase');
    Route::post('main-filter/price-limit', 'FilterController@priceLimit')->name('main-filter.priceLimit');
});
//criar o controlador  e seu metodos
//voltar na view e definir a rota no data-action
//configurar no arquivo js que irá enviar o post via ajax(sem refrsh)
//para atualizar o arquivo scripts.js dentro de resources de forma em tempo real. npm run watch
//dentro do js. Iremos capturar o select e enviar via ajax o valor selecionado
//parametrizar o ajaxsetup
//dentro do controlador passamos o Request
//no controlador, fazemos o filtro do valor recebido e retornamos para js.
//no js iremos tratr o dom, atraves da exibicao dos select , atraves do data-index
//repetir os prcessos comecando pela criacao da rota
//no controlador, criar outro metodo para ccategory, usando os mesmos processos do search

//apos concluiir todos os filtros, temos que apresentar na pagina os imoveis selecionados
//vamos utilizar a rota filto
//Route::get('/filtro', 'WebController@filter')->name('filter');
//no nosso controlador FilterController, temos o metodo createQuery, que recebe todos ids dos imoveis selecionados.
//temos que acessar esse metodo no controlador WebController, para isso vamos deixar ele como public
//dentro do metodo filter do contrador WebController, iremos instanciar o FilterController
//nossa rota tava como get, estava aparecendo todos nossos valores na barra de endereço
//colocamos o forms da pagina home como post
//nossa rota //Route::get('/filtro', 'WebController@filter')->name('filter'); poderiamos colocar como post, mas como ela pode ser acessada tmb pelo endereço ou seja get e post
//colocamos a rota como match
// Route::match(['post', 'get'], '/filtro', 'WebController@filter')->name('filter');

//dentro da view filter.blade vamos utilizar os mesmos data-action e name da view home.blade para filtrar os imoveis 

//=========================================================
//MENU ALUGAR E COMPRAR
//=========================================================
//listando os imoveis
//no controlador webController no metodo rent, iremos usar os scopes available e rent
//para listar todos imoveis, clicando nos menus alugar ou comprar, temos que limpar todas as sessions para nao gerar conflito
//no filterController iremos criar o metodo clearAllData , para limpar as sessions
//no webcontroller dentro de rent, iremos chamar o metodo clearAllData

//=========================================================
//CRIANDO ROTA PARA AS EXPERIENCIAS DA PAGINA HOME
//=========================================================
//criar uma rota Route::get('/experiencias', 'WebController@experience')->name('experience');
//no controlador webController no metodo experience retornamos com todo imvoes

//para retornar somente a experiencia selecionada, criamos uma rota pegando o nome da experiecnia
//Route::get('/experiencias/{slug}', 'WebController@experienceCategory')->name('experienceCategory');
// na view home, no link da experiencia, iremos chamar a rota passando o atributo da experiencia
//no contralador  webController no metodo experienceCategory, recebemos o atributo da rota atraves do Request

//==========================================================
//SEO/SEM Compartilhando informação certa
//==========================================================
//o seo é utilizando o coffecode optimizer dispo ivel pelo robosn
//inserimos a arquivo SEO em app/support
//inserios as tags de informações no .env
//baixar a package atraves do composer, composer require coffeecode/optimizer  |link  https://packagist.org/packages/coffeecode/optimizer
//inserir a tag {!! $head ?? '' !!} em todos topos de paginas
//inserimos o comado head dentro da fucntion home de WebController
//para reconhecer a comando seo dentro do webcontroller, entramos na class controller e adicionamos uma instancia da class seo

//conversar com corretor WHATSAPP
//so inserir no link esses paramentros como o contato : https://api.whatsapp.com/send?phone=DDI+DDD+TELEFONE&text=Olá, preciso de ajuda com o login."

//botao facebook
//https://developers.facebook.com/docs/plugins/share-button?locale=pt_BR
//inisrir codigo javascript
//insirir no html subustituindo pela url local
//{{ url()->current() }} pegar url atual

//botao twitter
//https://publish.twitter.com/#



//==========================================================
//ENVIANDO EMAIL
//==========================================================
//inserir os as configuraçoes necessarias no arquvio .env
// MAIL_DRIVER=smtp
// MAIL_HOST=smtp.sendgrid.net
// MAIL_PORT=465
// MAIL_USERNAME=apikey
// MAIL_PASSWORD=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
// MAIL_ENCRYPTION=ssl
//criar um arquivo do tipo Mail Mail\Web\Contact.php, atraves do comando
//php artisan make:mail Web\\Contact 
//no fomrulario de envio de email dentro de property.blade.php, deixamos ele como POST
//criar uma rota post, para metodo sendEmail
//no metodo sendEmail, vamos receber os dados recebidos pelo form atraves do request
//instanciar a classe Mail\Web\Contact.php e enviar atraves dela o array com os dados recebidos
//no arquivo Mail\Web\Contact.php, inserimos o array $data o contrutor, crio um atributo na classe e coloco ele p receber o valor do construtor
//no arquivo Mail\Web\Contact.php, no metodo build(), iremos costruir o formato do email
//o comando markdown é feito atraves uma view emails/contact.blade.php
//por fim iremos criar a rota de return para mensagem de sucesso ou nao