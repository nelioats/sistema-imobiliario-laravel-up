<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use App\Support\Message;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Estamos inserido esses codigos para servir como fabrica de mensagens de requisiços
    protected $message;

    //usado para instanciar a class seo
    protected $seo;

    public function __construct()
    {

        $this->message = new Message();
        $this->seo = new Seo();
    }
}
