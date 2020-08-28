<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //precisamos pelo menos informar todos campos nao nulo
        //vamos usar o arquivo .env para informar alguns valores padroes. como o email e senha
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => env('ADMIN_EMAIL'),
            'email_verified_at' => now(),
            'password' => password_hash(env('ADMIN_PASSWORD'), PASSWORD_DEFAULT),
            'remember_token' => Str::random(10),
            'document' => '',
            'admin' => 1,

        ]);
    }
}
