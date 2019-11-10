<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class AsteroidApiController extends Controller
{
    public function getAsteroids()
    {
        if (\Cache::has('asteroids')) {
            return \Cache::get('asteroids');
        } else {
            $client = new Client([
                'base_uri' => 'https://nasaapidimasv1.p.rapidapi.com/'
            ]);

            $response = $client->request('POST', 'getAsteroids', [
                'headers' => [
                    'x-rapidapi-host' => 'NasaAPIdimasV1.p.rapidapi.com',
                    'x-rapidapi-key' => 'e0284ab639mshb99c256c5c32fa1p14933ejsn8958ab8ffa51'
                ],
                'data' => [
                    'apiKey' => 'WHbzP6AqCF6ell7nP1ZcNaoPga9K65suD5DJukey'
                ]
            ]);

            $json = $response->getBody()->getContents();

            $expiresAt = Carbon::now()->addHour(10);

            \Cache::add('asteroids', $json, $expiresAt);

            return $json;
        }
    }
}
