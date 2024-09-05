<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificateCardController extends Controller
{
    //
    public function index(){
        return view('layouts.components.card_certificate');
    }
}
