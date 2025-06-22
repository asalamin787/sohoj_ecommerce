<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Payouts
{

    public static function token()
    {
        $client_id = setting('site.client_id');
        $secret_id = setting('site.paypal_secret_id');
        $endpoint = ['local' => 'https://api.sandbox.paypal.com/v1/oauth2/token', 'production' => 'https://api-m.paypal.com/v1/oauth2/token'];
        $res = Http::withBasicAuth($client_id, $secret_id)
            ->asForm()
            ->post($endpoint[env('APP_ENV')], ['grant_type' => 'client_credentials']);
            // dd($res->body());
        return (json_decode($res->body())->access_token);
    }
}
