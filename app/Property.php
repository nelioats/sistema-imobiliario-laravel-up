<?php

namespace App;

use App\User;
use App\PropertyImage;
use App\Support\Cropper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    protected $fillable = [
        'sale',
        'rent',
        'category',
        'type',
        'user',
        'sale_price',
        'rent_price',
        'tribute',
        'condominium',
        'description',
        'bedrooms',
        'suites',
        'bathrooms',
        'rooms',
        'garage',
        'garage_covered',
        'area_total',
        'area_util',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
        'air_conditioning',
        'bar',
        'library',
        'barbecue_grill',
        'american_kitchen',
        'fitted_kitchen',
        'pantry',
        'edicule',
        'office',
        'bathtub',
        'fireplace',
        'lavatory',
        'furnished',
        'pool',
        'steam_room',
        'view_of_the_sea',
        'status',
        'title',
        'slug',
        'headline',
        'experience'


    ];


    //========================================================
    //RELACIONAMENTOS
    //========================================================

    public function user()
    {
        //muitos para um = varias copanhias pode ter um usuario
        //muitos para um(Qual modelo quero me relacionar,  'qual é minha chave estrangeira que faz referencia a esse modelo'   , 'la no modelo, qual campo eu quero comparar')
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function images()
    {
        //um para muitos(Qual modelo quero me relacionar,  'qual id desse modelo me faz referencia'   , 'qual meu id faz referencia a ele')
        return $this->hasMany(PropertyImage::class, 'property', 'id')
            ->orderBy('cover', 'ASC');
    }

    //metodo para retornar somente a imagem principal(a que tem o cover como 1)
    public function cover()
    {
        //para imoves com imagem principal setada
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']); //quero obter somente a coluna path

        //para imoveis sem imagem principal setada (cover é null). retornará a primeira imagem do imovel
        if (!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }
        //para imoveis sem imagem (definir imagem padrão)
        //em caso do cover tiver vazio ou nao existir nenhum path no diretorio
        if (empty($cover['path']) || !File::exists('../public/storage/' . $cover['path'])) {
            return url(asset('backend/assets/images/default-image.png'));
        }


        return Storage::url(Cropper::thumb($cover['path'], 1366, 768));
    }





    //========================================================
    //TRATANDO COM OS SET  e  GET 
    //========================================================
    //comecar a modelar os campos necessarios para serem salvos no banco
    //formatar os campos checkbox, salvando 1 para true|on(selecionado) e 0 para false
    //formatar os campos de moeda para serem salvos sem , em tipo float
    //get pra tratar a varivel vinda do banco

    //tratando o campo checkbox
    public function setSaleAttribute($value)
    {
        $this->attributes['sale'] = (($value == true || $value == 'on') ? 1 : 0);
    }
    public function setRentAttribute($value)
    {
        $this->attributes['rent'] = (($value == true || $value == 'on') ? 1 : 0);
    }




    //tratando o campo sale_price, transfomando ele de string para double e removendo as virgulas
    //verifica se ele existe, caso nao, define null para ele
    //no final converte ele para float, para que fique igual ao tipo do banco de dados
    public function setSalePriceAttribute($value)
    {

        if (empty($value)) {
            $this->attributes['sale_price'] = null;
        } else {
            $this->attributes['sale_price'] = floatval($this->convertStringToDouble($value));
        }
    }

    public function getSalePriceAttribute($value)
    {
        //fomatando a variavel sale_price vinda do banco
        //number_format($value,quantidade de casas deciamis,'separador das casas decimais','separador das casas dos milhares');
        return number_format($value, 2, ',', '.');
    }




    public function setRentPriceAttribute($value)
    {

        if (empty($value)) {
            $this->attributes['rent_price'] = null;
        } else {
            $this->attributes['rent_price'] = floatval($this->convertStringToDouble($value));
        }
    }
    public function getRentPriceAttribute($value)
    {
        //fomatando a variavel rent_price vinda do banco
        //number_format($value,quantidade de casas deciamis,'separador das casas decimais','separador das casas dos milhares');
        return number_format($value, 2, ',', '.');
    }




    public function setTributeAttribute($value)
    {

        if (empty($value)) {
            $this->attributes['tribute'] = null;
        } else {
            $this->attributes['tribute'] = floatval($this->convertStringToDouble($value));
        }
    }
    public function getTributeAttribute($value)
    {
        //fomatando a variavel tribute vinda do banco
        //number_format($value,quantidade de casas deciamis,'separador das casas decimais','separador das casas dos milhares');
        return number_format($value, 2, ',', '.');
    }




    public function setCondominiumAttribute($value)
    {

        if (empty($value)) {
            $this->attributes['condominium'] = null;
        } else {
            $this->attributes['condominium'] = floatval($this->convertStringToDouble($value));
        }
    }
    public function getCondominiumAttribute($value)
    {
        //fomatando a variavel sale_price vinda do banco
        //number_format($value,quantidade de casas deciamis,'separador das casas decimais','separador das casas dos milhares');
        return number_format($value, 2, ',', '.');
    }








    //tratando os campos checkboxs
    public function setAirConditioningAttribute($value)
    {
        $this->attributes['air_conditioning'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setBarAttribute($value)
    {
        $this->attributes['bar'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setLibraryAttribute($value)
    {
        $this->attributes['library'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setBarbecueGrillAttribute($value)
    {
        $this->attributes['barbecue_grill'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setAmericanKitchenAttribute($value)
    {
        $this->attributes['american_kitchen'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setFittedKitchenAttribute($value)
    {
        $this->attributes['fitted_kitchen'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setPantryAttribute($value)
    {
        $this->attributes['pantry'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setEdiculeAttribute($value)
    {
        $this->attributes['edicule'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setOfficeAttribute($value)
    {
        $this->attributes['office'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setBathtubAttribute($value)
    {
        $this->attributes['bathtub'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setFirePlaceAttribute($value)
    {
        $this->attributes['fireplace'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setLavatoryAttribute($value)
    {
        $this->attributes['lavatory'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setFurnishedAttribute($value)
    {
        $this->attributes['furnished'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setPoolAttribute($value)
    {
        $this->attributes['pool'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    public function setSteamRoomAttribute($value)
    {
        $this->attributes['steam_room'] = (($value === true || $value === 'on') ? 1 : 0);
    }


    public function setViewOfTheSeaAttribute($value)
    {
        $this->attributes['view_of_the_sea'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    ////criando url amigavel para os imoveis serem apresentados na web
    public function setSlug()
    {
        if (!empty($this->title)) {
            $this->attributes['slug'] = Str::slug($this->title) . '-' . $this->id;
            $this->save();
        }
    }


    //no caso de CEP, temos que transformar para uma valor válido para o banco. EX: 65061450
    public function setzipcodeAttribute($value)
    {
        $this->attributes['zipcode'] = $this->clearField($value);
    }
    //no caso de CEP, temos que transformar para uma valor válido para exibir. EX: 65061-450
    public function getzipcodeAttribute($value)
    {
        return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    }




    //===================================================
    //INSERINDO O CAMPO STATUS
    //===================================================
    public function setStatusAttribute($value)
    {
        //se receber status com valor 1, quer dizer que é true senao false
        //no banco de dados 1 é true
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function getStatusAttribute($value)
    {
        return ($value == 1 ? true : false);
    }





    //===================================================
    //FUNCOES PRIVADAS
    //===================================================

    //funcao para converter string em double para formato adequado ao banco de dados
    //removendo , e substituindo , por .
    private function convertStringToDouble(?string $param)
    {
        //como o valor é moeda, em caso de vazio, temos que retornar nulo
        if (empty($param)) {
            return null;
        }
        return str_replace(',', '.', str_replace(['.'], '', $param));
    }
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return '';
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }


    //===================================================
    //SCOPES = retorna somente os resultados das consultas
    //===================================================
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }
    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }

    public function scopeSale($query)
    {
        return $query->where('sale', 1);
    }
    public function scopeRent($query)
    {
        return $query->where('rent', 1);
    }
}
