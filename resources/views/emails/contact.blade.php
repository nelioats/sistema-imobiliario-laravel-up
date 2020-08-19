@component('mail::message')
# Novo Contato

<p>Contato: {{ $name }}</p> 
<p>E-mail: {{ $email }} </p>
<p>Telefone: {{ $cell }}</p>
Mensagem:
    <br>
{{ $message }}
<br>
    * Este E-mail é enviado automaticamente pelo sistema!
@endcomponent