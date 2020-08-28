<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'purpouse',
        'owner',
        'owner_spouse',
        'owner_company',
        'acquirer',
        'acquirer_spouse',
        'acquirer_company',
        'property',
        'sale_price',
        'rent_price',
        'price',
        'tribute',
        'condominium',
        'due_date',
        'deadline',
        'start_at',
        'status'
    ];

    //=================================================================================
    //RELACIONAMENTOS
    //=================================================================================
    //hasOne(muitos para um - devolve somente um objeto)
    //relacionamento com modelo USER, 
    // id - minha chave estrangeira para o relacionamento dentro da tabela USER
    // owner e acquirer - minha chave local para o relacionamento dentro da tabela CONTRACT
    public function ownerObject()
    {

        return $this->hasOne(User::class, 'id', 'owner');
    }

    public function acquirerObject()
    {

        return $this->hasOne(User::class, 'id', 'acquirer');
    }

    //esse relacionamento foi criado para apresentar a empresa do contrato no campo termos
    //'id' chave estrangeira aq do relacionamento da tabela company
    //owner_company chave da tabela local(contract) que faz ligacao com o id da tabela company 
    public function ownerCompanyObject()
    {
        return $this->hasOne(Company::class, 'id', 'owner_company');
    }

    public function acquirerCompanyObject()
    {
        return $this->hasOne(Company::class, 'id', 'acquirer_company');
    }

    //relacionamento dos imoveis
    public function propertyObject()
    {
        return $this->hasOne(Property::class, 'id', 'property');
    }



    //=================================================================================
    //criando os metodos SET para padronizar os campos com os formatos dos campos do banco de dados 
    //=================================================================================

    //definimos sale = 1 e rent como 0, pois nao podem ser selcionados os dois ao mesmo tempo
    // public function setSaleAttribute($value)
    // {
    //     if ($value === true || $value === 'on') {
    //         $this->attributes['sale'] = 1;
    //         $this->attributes['rent'] = 0;
    //     }
    // }
    // //definimos sale = 1 e rent como 0, pois nao podem ser selcionados os dois ao mesmo tempo
    // public function setRentAttribute($value)
    // {
    //     if ($value === true || $value === 'on') {
    //         $this->attributes['rent'] = 1;
    //         $this->attributes['sale'] = 0;
    //     }
    // }

    public function setPurpouseAttribute($value)
    {
        if ($value == 'sale') {
            $this->attributes['purpouse'] = 'sale';
        } else {
            $this->attributes['purpouse'] = 'rent';
        }
    }


    //como no banco o Owner Spouse é um boolean, pois ele é casado ou nao. Temos que salvar no banco como 1(true) ou 0(false)
    public function setOwnerSpouseAttribute($value)
    {
        $this->attributes['owner_spouse'] = ($value === '1' ? 1 : 0);
    }

    // Para owner_company, podemos salvar um inteiro (sendo selecionado uma empresa) ou  null se nao for selecionado nada
    public function setOwnerCompanyAttribute($value)
    {
        if ($value == '0') {
            $this->attributes['owner_company'] = null;
        } else {
            $this->attributes['owner_company'] = $value;
        }
    }

    //como no banco o acquirer_spouse é um boolean, pois ele é casado ou nao. Temos que salvar no banco como 1(true) ou 0(false)
    public function setAcquirerSpouseAttribute($value)
    {
        $this->attributes['acquirer_spouse'] = ($value === '1' ? 1 : 0);
    }

    // Para acquirer_company, podemos salvar um inteiro (sendo selecionado uma empresa) ou  null se nao for selecionado nada
    public function setAcquirerCompanyAttribute($value)
    {
        if ($value == '0') {
            $this->attributes['acquirer_company'] = null;
        } else {
            $this->attributes['acquirer_company'] = $value;
        }
    }

    //capturando os campos sale_price ou rent_price e salvando no campo price do banco como double
    public function setSalePriceAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['price'] = floatval($this->convertStringToDouble($value));
        }
    }
    public function setRentPriceAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['price'] = floatval($this->convertStringToDouble($value));
        }
    }

    //get price
    public function getPriceAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }




    //capturando os campos tribute ou condominium e salvando no banco como double
    public function setTributeAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['tribute'] = floatval($this->convertStringToDouble($value));
        }
    }
    public function setCondominiumAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['condominium'] = floatval($this->convertStringToDouble($value));
        }
    }

    //get tribute
    public function getTributeAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }
    //get Condominium
    public function getCondominiumAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }



    //confgurando o campo start_at para tipo DATE
    public function setStartAtAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['start_at'] = $this->convertStringToDate($value);
        }
    }

    //get tribute
    public function getStartAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }





    //=======================================================================
    //FUNCOES HELPERS
    //=======================================================================
    private function convertStringToDouble($param)
    {
        if (empty($param)) {
            return null;
        }

        return  str_replace(',', '.', str_replace('.', '', $param));
    }

    private function convertStringToDate($param)
    {
        if (empty($param)) {
            return null;
        }

        list($dia, $mes, $ano) = explode('/', $param);
        return (new DateTime($ano . '-' . $mes . '-' . $dia))->format('Y-m-d');
    }


    //===================================================
    //SCOPES
    //===================================================
    public function scopePendent($query)
    {
        return $query->where('status', 'pendent');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }






    //=======================================================================
    //TERMO DO CONTRATO
    //=======================================================================
    public function terms()
    {
        // Finalidade [Venda/Locação]
        if ($this->purpouse == 'sale') {
            $parameters = [
                'purpouse' => 'VENDA',
                'part' => 'VENDEDOR',
                'part_opposite' => 'COMPRADOR',
            ];
        }

        if ($this->purpouse == 'rent') {
            $parameters = [
                'purpouse' => 'LOCAÇÃO',
                'part' => 'LOCADOR',
                'part_opposite' => 'LOCATÁRIO',
            ];
        }

        $terms[] = "<p style='text-align: center;'>{$this->id} - CONTRATO DE {$parameters['purpouse']} DE IMÓVEL</p>";

        // OWNER
        if (!empty($this->owner_company)) { // Se tem empresa

            if (!empty($this->owner_spouse)) { // E tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->ownerCompanyObject->document_company} e I. E. nº {$this->ownerCompanyObject->document_company_secondary} exercendo suas atividades no endereço {$this->ownerCompanyObject->street}, nº {$this->ownerCompanyObject->number}, {$this->ownerCompanyObject->complement}, {$this->ownerCompanyObject->neighborhood}, {$this->ownerCompanyObject->city}/{$this->ownerCompanyObject->state}, CEP {$this->ownerCompanyObject->zipcode} tendo como responsável legal {$this->ownerObject->name}, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->civil_status}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->document}, e cônjuge {$this->ownerObject->spouse_name}, natural de {$this->ownerObject->spouse_place_of_birth}, {$this->ownerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->spouse_document_secondary} {$this->ownerObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->spouse_document}, residentes e domiciliados à {$this->ownerObject->street}, nº {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->ownerCompanyObject->document_company} e I. E. nº {$this->ownerCompanyObject->document_company_secondary} exercendo suas atividades no endereço {$this->ownerCompanyObject->street}, nº {$this->ownerCompanyObject->number}, {$this->ownerCompanyObject->complement}, {$this->ownerCompanyObject->neighborhood}, {$this->ownerCompanyObject->city}/{$this->ownerCompanyObject->state}, CEP {$this->ownerCompanyObject->zipcode} tendo como responsável legal {$this->ownerObject->name}, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->civil_status}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->document}, residente e domiciliado à {$this->ownerObject->street}, nº {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            }
        } else { // Se não tem empresa

            if (!empty($this->owner_spouse)) { // E tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerObject->name}</b>, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->civil_status}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->document}, e cônjuge {$this->ownerObject->spouse_name}, natural de {$this->ownerObject->spouse_place_of_birth}, {$this->ownerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->spouse_document_secondary} {$this->ownerObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->spouse_document}, residentes e domiciliados à {$this->ownerObject->street}, nº {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerObject->name}</b>, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->civil_status}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->document}, residente e domiciliado à {$this->ownerObject->street}, nº {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            }
        }

        // ACQUIRER
        if (!empty($this->acquirer_company)) { // Se tem empresa

            if (!empty($this->acquirer_spouse)) { // E tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->acquirerCompanyObject->document_company} e I. E. nº {$this->acquirerCompanyObject->document_company_secondary} exercendo suas atividades no endereço {$this->acquirerCompanyObject->street}, nº {$this->acquirerCompanyObject->number}, {$this->acquirerCompanyObject->complement}, {$this->acquirerCompanyObject->neighborhood}, {$this->acquirerCompanyObject->city}/{$this->acquirerCompanyObject->state}, CEP {$this->acquirerCompanyObject->zipcode} tendo como responsável legal {$this->acquirerObject->name}, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->civil_status}, {$this->acquirerObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->document}, e cônjuge {$this->acquirerObject->spouse_name}, natural de {$this->acquirerObject->spouse_place_of_birth}, {$this->acquirerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->spouse_document_secondary} {$this->acquirerObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->spouse_document}, residentes e domiciliados à {$this->acquirerObject->street}, nº {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->acquirerCompanyObject->document_company} e I. E. nº {$this->acquirerCompanyObject->document_company_secondary} exercendo suas atividades no endereço {$this->acquirerCompanyObject->street}, nº {$this->acquirerCompanyObject->number}, {$this->acquirerCompanyObject->complement}, {$this->acquirerCompanyObject->neighborhood}, {$this->acquirerCompanyObject->city}/{$this->acquirerCompanyObject->state}, CEP {$this->acquirerCompanyObject->zipcode} tendo como responsável legal {$this->acquirerObject->name}, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->civil_status}, {$this->acquirerObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->document}, residente e domiciliado à {$this->acquirerObject->street}, nº {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            }
        } else { // Se não tem empresa

            if (!empty($this->acquirer_spouse)) { // E tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerObject->name}</b>, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->civil_status}, {$this->acquirerObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->document}, e cônjuge {$this->acquirerObject->spouse_name}, natural de {$this->acquirerObject->spouse_place_of_birth}, {$this->acquirerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->spouse_document_secondary} {$this->acquirerObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->spouse_document}, residentes e domiciliados à {$this->acquirerObject->street}, nº {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerObject->name}</b>, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->civil_status}, {$this->acquirerObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->document}, residente e domiciliado à {$this->acquirerObject->street}, nº {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            }
        }

        $terms[] = "<p style='font-style: italic; font-size: 0.875em;'>A falsidade dessa declaração configura crime previsto no Código Penal Brasileiro, e passível de apuração na forma da Lei.</p>";

        $terms[] = "<p><b>5. IMÓVEL:</b> {$this->propertyObject->category}, {$this->propertyObject->type}, localizada no endereço {$this->propertyObject->street}, nº {$this->propertyObject->number}, {$this->propertyObject->complement}, {$this->propertyObject->neighborhood}, {$this->propertyObject->city}/{$this->propertyObject->state}, CEP {$this->propertyObject->zipcode}</p>";

        $terms[] = "<p><b>6. PERÍODO:</b> {$this->deadline} meses</p>";

        $terms[] = "<p><b>7. VIGÊNCIA:</b> O presente contrato tem como data de início {$this->start_at} e o término exatamente após a quantidade de meses descrito no item 6 deste.</p>";

        $terms[] = "<p><b>8. VENCIMENTO:</b> Fica estipulado o vencimento no dia {$this->due_date} do mês posterior ao do início de vigência do presente contrato.</p>";

        $terms[] = "<p>Florianópolis, " . date('d/m/Y') . ".</p>";

        $terms[] = "
          <table width='100%' style='margin-top: 50px;'>
             <tr>
                <td>_________________________</td>
                " . ($this->owner_spouse ? "<td>_________________________</td>" : "") . "
             </tr>
             <tr>
                <td>{$parameters['part']}: {$this->ownerObject->name}</td>
                " . ($this->owner_spouse ? "<td>Conjuge: {$this->ownerObject->spouse_name}</td>" : "") . "
             </tr>
             <tr>
                <td>Documento: {$this->ownerObject->document}</td>
                " . ($this->owner_spouse ? "<td>Documento: {$this->ownerObject->spouse_document}</td>" : "") . "
             </tr>
         </table>";


        $terms[] = "
          <table width='100%' style='margin-top: 50px;'>
             <tr>
                <td>_________________________</td>
                " . ($this->acquirer_spouse ? "<td>_________________________</td>" : "") . "
             </tr>
             <tr>
                <td>{$parameters['part_opposite']}: {$this->acquirerObject->name}</td>
                " . ($this->acquirer_spouse ? "<td>Conjuge: {$this->acquirerObject->spouse_name}</td>" : "") . "
             </tr>
             <tr>
                <td>Documento: {$this->acquirerObject->document}</td>
                " . ($this->acquirer_spouse ? "<td>Documento: {$this->acquirerObject->spouse_document}</td>" : "") . "
             </tr>
          </table>";

        $terms[] = "
          <table width='100%' style='margin-top: 50px;'>
             <tr>
                <td>_________________________</td>
                <td>_________________________</td>
             </tr>
             <tr>
                <td>1ª Testemunha: </td>
                <td>2ª Testemunha: </td>
             </tr>
             <tr>
                <td>Documento: </td>
                <td>Documento: </td>
             </tr>
          </table>";

        return implode('', $terms);
    }
}
