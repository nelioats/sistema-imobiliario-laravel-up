<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'view_of_the_sea'
     ];
}
