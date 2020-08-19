@extends('web.master.master')

@section('content')
<div class="container p-5">
<h2 class="text-center  bg-white text-front">Seu contato foi enviado com sucesso! Em breve entraremos em contato</h2> 
<p class="text-center"><a href="{{ url()->previous() }}" class="text-front">...Contiuar Navegando!</a></p>
</div>
@endsection