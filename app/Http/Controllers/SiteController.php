<?php

namespace App\Http\Controllers;

use App\Site;
use App\Ad;
use ErrorException;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function search() {
        $query = request()->input('query');
        $query_components = array_unique(explode(' ', $query));
        $sites = Site::where('content', 'LIKE', '%'.$query.'%');
        $advert = Ad::where('keywords', 'LIKE', '%'.$query.'%');

        foreach ($query_components as $component) {
            $sites->orWhere('content', 'LIKE', '%'.$query.'%');
        }

        foreach ($query_components as $component) {
            $advert->orWhere('keywords', 'LIKE', '%'.$query.'%');
        }

        $sites = $sites->get();
        $advert = $advert->first();

        if($sites->count() == 0) {
            return "No results found";
        }

        if($advert != null) {
            print("<h5>Advertising</h5>");
            print("<p>$advert->advert</p>");
        }

        print("<h1>Results:</h1>");
        foreach ($sites as $site){
            print("<h2><a href='{$site->url}'>$site->content</a></h2>");
        }
    }

    public function add() {
        $token = request()->input('token');
        if($token != "CSC3065") return;

        $url = request()->input('url');
        $content = request()->input('content');

        try{
            $site = Site::where('url', $url)->first();
            $site->content = $content;
            $site->save();
        } catch (ErrorException $e) {
            $site = new Site;
            $site->url = $url;
            $site->content = $content;
            $site->save();
        }
    }
}
