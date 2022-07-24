<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // $config = config('services.maxmind');
        // $geoip = new MaxMindGeoLite($config['account_id'], $config['license_key']);

        // $country = $geoip->country('213.244.80.165');

        $latest =Product::latest()->take(10)->get();
        return view('front.home', [
            'latest' => $latest,
        ]);
    }
}
