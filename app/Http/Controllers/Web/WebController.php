<?php

namespace App\Http\Controllers\Web;

use App\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function home()
    {
        //usando a concatenação dos scopes(sale e available) conseguimos obter os imoves para venda e disponiveis
        $propertyForSale = Property::sale()->available()->limit(3)->get();
        $propertyForRent = Property::rent()->available()->limit(3)->get();

        return view('web.home', compact('propertyForSale', 'propertyForRent'));
    }

    public function rent()
    {
        return view('web.filter');
    }
    public function rentProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();
        return view('web.property', compact('property'));
    }



    public function buy()
    {
        return view('web.filter');
    }

    public function buyProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();
        dd($property);
    }
    public function filter()
    {
        return view('web.filter');
    }





    public function contato()
    {
        return view('web.contact');
    }
}
