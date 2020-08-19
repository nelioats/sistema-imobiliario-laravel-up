<?php

namespace App\Mail\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    //variavel criada para receber os valores do metodo sendEmail
    private $data;

    //inserimos o array $data no contrutor para receber os valores lancados no sendEmail 
    public function __construct(array $data)
    {
        $this->data = $data;
    }


    //     public function build()
    //     {
    //         return $this->from($this->data['replay_email'])
    //             ->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
    //             ->subject('Novo Contato: ' . $this->data['replay_name'])
    //             ->markdown(
    //                 'emails.contact',
    //                 [
    //                     'name' => $this->data['replay_name'],
    //                     'email' => $this->data['replay_email'],
    //                     'message' => $this->data['message'],
    //                     'cell' => $this->data['cell'],
    //                 ]
    //             );
    //     }
    // }


    public function build()
    {
        return $this->from($this->data['replay_email'], $this->data['replay_name'])
            ->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Novo Contato: ' . $this->data['replay_name'])
            ->markdown(
                'emails.contact',
                [
                    'name' => $this->data['replay_name'],
                    'email' => $this->data['replay_email'],
                    'cell' => $this->data['cell'],
                    'message' => $this->data['message'],
                ]
            );
    }
}
