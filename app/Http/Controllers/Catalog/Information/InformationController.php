<?php

namespace App\Http\Controllers\Catalog\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function privacyPolicy(){
        return view('catalog.information.privacy_policy');
    }
}
