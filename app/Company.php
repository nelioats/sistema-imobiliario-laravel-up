<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Company extends Model
{
    protected $fillable = [
        'user',
        'social_name',
        'alias_name',
        'document_company',
        'document_company_secondary',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
    ];

    //foi utilizado no comeco do curso, mas devido a questao de permormace, foi substituido pelo metodo abaixo
    // public function user(){
    //     //esse metodo é para chamar os atriutos do user
    //     //belongsTo() (muitos para um) - varias empresas para um usuario)( Classe que quer se relacionar, 'campo da minha tabela que tem a relação', 'campo id da tabela que estou fazendo a relação(id)');
    //     return $this->belongsTo(User::class,'user','id');
    // }
    public function owner()
    {
        //muitos para um - me relacionando com a classe User, 'chave estrangeira = id da tabela usuario' , 'localKey = user' 
        return $this->hasOne(User::class, 'id', 'user');
    }



    public function setDocumentCompanyAttribute($value)
    {
        $this->attributes['document_company'] = $this->clearField($value);
    }

    public function getDocumentCompanyAttribute($value)
    {
        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) . '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
    }

    //===================================================
    //FUNCOES PRIVADAS
    //===================================================
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return '';
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
