<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        $location = 'London';
        $openWeatherAppKey = config('services.openweather.key'); // openwether app key

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$openWeatherAppKey}&units=metric");
        //dump($response->json());

        $client = new \GuzzleHttp\Client();
        $tomorrowIoAppKey = config('services.tomorrow_io.key'); // tomorrow.io app key

        $responseFuture = $client->request('GET', 
            "https://api.tomorrow.io/v4/weather/forecast?location={$location}&apikey={$tomorrowIoAppKey}", [
            'headers' => [
                'accept' => 'application/json',
            ],
        ]);
        
        $responseFutureContents = json_decode($responseFuture->getBody()->getContents(), true);
        $responseFutureDaily = $responseFutureContents['timelines']['daily'];
        //dump($responseFutureContents['timelines']['daily']);

        return view('welcome', [
            'currentWeather' => $response->json(),
            'futureWeather' => $responseFutureDaily
        ]);

        // return view('welcome1');
    }
}
