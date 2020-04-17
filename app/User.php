<?php

namespace App;

use DateTime;
use App\Support\Cropper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'genre',
        'document' ,
        'document_secondary',
        'document_secondary_complement' ,
        'date_of_birth',
        'place_of_birth',
        'civil_status',
        'occupation' ,
        'income',
        'company_work',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
        'telephone',
        'cell',
        'email', 
        'type_of_communion',
        'spouse_name',
        'spouse_genre' ,
        'spouse_document', 
        'spouse_document_secondary',
        'spouse_document_secondary_complement' ,
        'spouse_date_of_birth', 
        'spouse_place_of_birth',
        'spouse_occupation',
        'spouse_income',
        'spouse_company_work' ,
        'lessor',
        'lessee',
        'admin',
        'client',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    //===================================================
    //MINHAS FUNCOES DE CONVERSÃO/ SET
    //===================================================
    public function setLessorAttribute($value){
        $this->attributes['lessor'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setLesseeAttribute($value){
        $this->attributes['lessee'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    //no caso de cpf, temos que transformar para uma valor válido para o banco. EX: 00514814306
    public function setDocumentAttribute($value){
        $this->attributes['document'] = $this->clearField($value);
    }

    //no caso de data, temos que transformar para uma data válida para o banco. EX: 1990-03-28
    public function setDateofBirthAttribute($value){
        $this->attributes['date_of_birth'] = $this->convertStringToDate($value);
    }

    //no caso de valor, temos que transformar para um valor válido para o banco e transfomá-lo em float. EX: 30000.50
    public function setIncomeAttribute($value){
        $this->attributes['income'] = floatval($this->convertStringToDouble($value));
    }

     //no caso de CEP, temos que transformar para uma valor válido para o banco. EX: 65061450
    public function setzipcodeAttribute($value){
        $this->attributes['zipcode'] = $this->clearField($value);
    }

    //no caso de TELEFONE, temos que transformar para uma valor válido para o banco. EX: 65061450
    public function settelephoneAttribute($value){
        $this->attributes['telephone'] = $this->clearField($value);
    }
    //no caso de CELULAR, temos que transformar para uma valor válido para o banco. EX: 65061450
    public function setCellAttribute($value){
        $this->attributes['cell'] = $this->clearField($value);
    }

    //no caso de PASSWORD, temos que transformar para uma valor válido para o banco. EX: 65061450
    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    public function setAdminAttribute($value){
        $this->attributes['admin'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setClientAttribute($value){
        $this->attributes['client'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    //===================================================
    //DADOS DO CONJUGE
    //===================================================
     //no caso de cpf, temos que transformar para uma valor válido para o banco. EX: 00514814306
     public function setSpouseDocumentAttribute($value){
        $this->attributes['spouse_document'] = $this->clearField($value);
    }

    //no caso de data, temos que transformar para uma data válida para o banco. EX: 1990-03-28
    public function setSpouseDateofBirthAttribute($value){
        $this->attributes['spouse_date_of_birth'] = $this->convertStringToDate($value);
    }

    //no caso de valor, temos que transformar para um valor válido para o banco e transfomá-lo em float. EX: 30000.50
    public function setSpouseIncomeAttribute($value){
        $this->attributes['spouse_income'] = floatval($this->convertStringToDouble($value));
    }


    //===================================================
    //FUNCOES PRIVADAS
    //===================================================
    //cpf
    //Caso seja passado uma valor null ou vazio, no caso o telefone que no foi informado no formulário, podemos colococar ? nos parametros  das funçoes, para inserir um valor padrão
    private function clearField(?string $param){
        if(empty($param)){
            return '';
        }
        return str_replace(['.','-','/','(',')',' '],'',$param);
    }

    public function convertStringToDate(?string $param){
        //como o valor é date, em caso de vazio, temos que retornar nulo
        if(empty($param)){
            return null;
        }

        list($day,$month,$year) = explode('/',$param);
        return (new DateTime($year.'-'.$month.'-'.$day))->format('Y-m-d');       
    }

    private function convertStringToDouble(?string $param){
         //como o valor é moeda, em caso de vazio, temos que retornar nulo
        if(empty($param)){
            return null;
        }
        return str_replace(',','.',str_replace(['.'],'',$param));
    }

    //===================================================
    //MINHAS FUNCOES DE RECEBIMENTO E TRTAMENTO/ GET
    //===================================================


    //no caso de cpf, temos que transformar para uma valor válido para apresentear para usuario
    public function getDocumentAttribute($value){
        return substr($value,0,3).'.'.substr($value,3,3).'.'.substr($value,6,3).'-'.substr($value,9,2);
    }

     //no caso de data, temos que transformar para uma data válida para apresentear para usuario
    public function getDateofBirthAttribute($value){
        return date('d/m/Y',strtotime($value));
    }

     //no caso de valor, temos que transformar para um valor válido para apresentear para usuario
     //number_format(variavel,numero de casas decimais,'operando q irá dividir as casas decimais',''operando q irá dividir as casas milhares'');
     public function getIncomeAttribute($value){
        return  number_format($value,2,',','.');
    }
      //no caso de cpf, temos que transformar para uma valor válido para apresentear para usuario
      public function getSpouseDocumentAttribute($value){
        return substr($value,0,3).'.'.substr($value,3,3).'.'.substr($value,6,3).'-'.substr($value,9,2);
    }

     //no caso de data, temos que transformar para uma data válida para apresentear para usuario
     public function getSpouseDateofBirthAttribute($value){
        return date('d/m/Y',strtotime($value));
    }

     //no caso de valor, temos que transformar para um valor válido para apresentear para usuario
     //number_format(variavel,numero de casas decimais,'operando q irá dividir as casas decimais',''operando q irá dividir as casas milhares'');
     public function getSpouseIncomeAttribute($value){
        return  number_format($value,2,',','.');
    }

    //===================================================
    //GET PARA OBTER IMAGEM NO STORAGE
    //===================================================

    // public function getUrlCoverAttribute(){
    //     return Storage::url($this->cover);
    // }
    // COM CROPPER
    public function getUrlCoverAttribute(){

        //criamos essa condição no caso de usuario sem imagem, pois necessita dos atributos preenchidos.
        if(!empty($this->cover)){
            return Storage::url(Cropper::thumb($this->cover,500,500));
        }else{
            return '';
        }
    }


}
