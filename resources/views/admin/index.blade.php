<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

<link rel="stylesheet" href="{{url(mix('backend/assets/css/reset.css'))}}"/>
    <link rel="stylesheet" href="{{url(mix('backend/assets/css/boot.css'))}}"/>
    <link rel="stylesheet" href="{{url(mix('backend/assets/css/login.css'))}}"/>
    <link rel="stylesheet" href="{{url(mix('backend/assets/css/toastr.css'))}}"/>
    <link rel="icon" type="image/png" href="backend/assets/images/favicon.png"/>

    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <title>UpAdmin - Site Control</title>
</head>
<body>

{{-- <div class="ajax_response"></div> --}}

<div class="dash_login">
    <div class="dash_login_left">
        <article class="dash_login_left_box">
            <header class="dash_login_box_headline">
                <div class="dash_login_box_headline_logo icon-imob icon-notext"></div>
                <h1>Login</h1>
            </header>



        <form  action="{{route('admin.login.do')}}" method="post" >
            {{-- name="login" --}}
            {{-- autocomplete="off" --}}
            @csrf
                <label>
                    <span class="field icon-envelope">E-mail:</span>
                    <input type="text" name="email" placeholder="Informe seu e-mail" required/>
                </label>

                <label>
                    <span class="field icon-unlock-alt">Senha:</span>
                    <input type="password" name="password" placeholder="Informe sua senha" />
                </label>

                <button class="gradient gradient-orange radius icon-sign-in">Entrar</button>
            </form>

            <footer>
                <p>Desenvolvido por <a href="https://www.upinside.com.br">www.<b>upinside</b>.com.br</a></p>
                <p>&copy; <?= date("Y"); ?> - Todos os Direitos Reservados</p>
                <p class="dash_login_left_box_support">
                    <a target="_blank"
                       class="icon-whatsapp transition text-green"
                       href="https://api.whatsapp.com/send?phone=DDI+DDD+TELEFONE&text=Olá, preciso de ajuda com o login."
                    >Precisa de Suporte?</a>
                </p>
            </footer>
        </article>
    </div>

    <div class="dash_login_right"></div>

</div>

<script src="{{url(mix('backend/assets/js/jquery.js'))}}"></script>
<script src="{{url(mix('backend/assets/js/login.js'))}}"></script>
<script src="{{url(mix('backend/assets/js/toastr.js'))}}"></script>
<script>

@if (Session::has('success'))toastr.success("{{ Session::get('success')}}",'',{"progressBar": true})@endif
@if (Session::has('error'))toastr.error("{{ Session::get('error')}}",'',{"progressBar": true})@endif

</script>


</body>
</html>