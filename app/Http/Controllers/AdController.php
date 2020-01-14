<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Site;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function add() {
        $keywords = request()->input('keywords');
        $advert = request()->input('advert');
        $ad = new Ad;
        $ad->keywords = $keywords;
        $ad->advert = $advert;
        $ad->save();
    }
}
