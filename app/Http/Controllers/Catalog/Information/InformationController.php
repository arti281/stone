<?php

namespace App\Http\Controllers\Catalog\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function refund(){
        return view('catalog.information.refund-return-policy');
    }

    public function about(){
         return view('catalog.information.aboutus');

    }

    public function term(){
         return view('catalog.information.terms-condition');

    }

    public function privacy(){
         return view('catalog.information.privacy-policy');

    }

     public function policy(){
         return view('catalog.information.shipping-policy');

    }

}
