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
////CADASTRO DE USUÁRIO - VALIDANDO OS DADOS COM O METODO FILLABLE NO MODELO
//==================================================================================
//no modelo users, inserimos todos os campos no metodo fillable.
//dentro do controlador $user = new User(); user->fill($request->all()); para testar as validacoes do metodo fillable
//dentro do modelo users, para se criar os filtros, onde irão converter os dados para DADOS COMPATIVEIS COM O BANCO DE DADOS.
//temos que criar metodos para cada atributo, definindo sua regras de negocio. Ex: (é obrigaatorio o uso da palavra set + nome + Attribute)
// public function setLessorAttribute($value){
//     $this->attributes['lessor'] = ($value === true || $value === 'on' ? 1 : 0);
// }


//==================================================================================
////CADASTRO DE USUÁRIO - PERSISTIR OS DADOS NO BANCO
//==================================================================================
//criar a migration para inserir as colunas na tabela usuarios
//php artisan make:migration alter_users_table --table=users
//definir os campos da tabela na migration
//executar a migration
//php artisan migration
// no controlado, utlizar o metodo $userCreate = User::create($request->all()) para criar o ususario no banco
//caso erre algum nome na migrtion. Corrigir a migration e executar: php artisan migrate:refresh


//==================================================================================
////LISTAGEM DE USUÁRIO - 
//==================================================================================
//No metodo index, do controlador UserController, listar todos usuarios e enviar para view
//na view, como metodo foreach do blade chamar a coleção recebida pela view

//==================================================================================
////EDIÇÃO DE USUÁRIO - 
//==================================================================================
//dentro da view admin/users/index, no campo nome, criamos um link com a rota: {{route('admin.users.edit',['user'=>$user->id])}}. para enviar o id do usuario que ir´sofrer a edição
//no metodo edit do controlador UserController, recebemos o id, filtramos com where, e enviamos para view admin/users/edit
//*********lembrete : first para receber um registro | get para receber uma coleção  ******************/
//a view edit é uma cópia da view create, no form , teremos que alterar a rota de route('admin.users.store') para route('admin.users.update')
//inserir abaixo do @csrf a tag  @method('PUT')
//na view edit, no campo value, tem q deixar o old e receber o valor fornecido pelo banco. como o metdo novo do php value="{{old('name') ?? $user->name}}"


//==================================================================================
////RECEBENDO DADOS DO USUÁRIO - FORMATANDO OS DADOS PARA APRESENTAÇÃO - NO MODELO
//==================================================================================
//Durante a inserção dos dados, no modelo usamos o set. Para receber os dados e formata-los, usamos o get
//No metodo update do controlador UserController, usamos nosso formrequest criado(UserRequest)
//para que os campos de checkbox nao fiquem com campos vazios, caso seja altrado pelo usuario. Inserimos os meotodos set do modelo USER