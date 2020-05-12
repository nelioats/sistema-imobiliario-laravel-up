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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as'=>'admin.'], function () {

    // rotas de login
    Route::get('/','AuthController@showLoginForm')->name('login');
    Route::post('login','AuthController@login')->name('login.do');
    
    // rotas protegidas
    Route::group(['middleware' => ['auth']], function () {

        // dashboard home
        Route::get('home','AuthController@home')->name('home');

        // dashboard usuarios
        //
        Route::get('users/team','UserController@team')->name('users.team');
        Route::resource('users','UserController');

        //rotas para EMPRESA
        Route::resource('companies','CompanyController');

        //rotas para PROPERTY
        Route::resource('properties','PropertyController');

    });
    

    // logout
    Route::get('logout','AuthController@logout')->name('logout');

    
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
//php artisan make:model Property -m
//php artisan make:controller Admin\\PropertyController --resource
//criamos as rotas no arquivo web.php 
//configurando os links na view admin.master.master.blade.php ({{ isActive('admin.properties') }})
//definindo as views dentro do controlador
//na view create, inserir o @csrf no form | route(create)
//no metodo store do controlador. Instanciar o modelo Property e usaro metodo fill
//no modelo, inserir o metodo protected $fillable = [ ];