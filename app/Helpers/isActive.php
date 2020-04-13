<?php

if(! function_exists('isActive')){

    function isActive($href, $class = 'active'){

        return $class = (strpos(Route::currentRouteName() , $href) === 0 ? $class : '');

        //strpos
        //==================
        //Encontra a posição da primeira ocorrência de uma string
        //Esta função pode retornar o booleano FALSE, mas também pode retornar um valor não-booleano que pode ser avaliado como FALSE, como 0 ou "".

    }

}