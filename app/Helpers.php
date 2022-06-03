<?php
namespace App;

use App\Models\Orders;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class Helpers{
    public static function sendOrder($input)
    {
        $nonce = Str::random(16);
        $seed = date('Y-m-d\TH:i:sP');
        $trankey = base64_encode(sha1($nonce.$seed.env('TRANKEY_EVERTEC'), true));
        $nonce = base64_encode($nonce);
        $seed = date('Y-m-d\TH:i:sP');
        $json = json_encode([
            'payment'=>[
                'reference'=>Str::random(4),
                'description'=> 'Compra tienda Evertec',
                'amount'=>[
                    'currency'=>'COP',
                    'total'=> \Cart::getTotal() 
                ]
            ],
            "buyer" => [
                "name" => $input['firstName'], 
                "surname" => $input['lastName'], 
                "email" => $input['email'], 
                "document" => $input['document'], 
                "documentType" => "CC", 
                "mobile" => $input['mobile'] 
            ], 
            'expiration'=>"2023-06-02T23:04:24-05:00",
            'returnUrl'=>env('URL_BACK'),
            'ipAddress'=>'201.185.219.95',
            'userAgent'=>'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36',
            'locale' => 'es_CO',
            'auth' => [
                'login'   => env('LOGIN_EVERTEC'),
                'tranKey' => $trankey,
                'nonce'   => $nonce,
                'seed'    => $seed
            ]
            ]);

        $client = new Client();
        $response = $client->request('POST', 'https://dev.placetopay.com/redirection/api/session', [
            'headers' => [
                'Content-Type'     => 'application/json',
            ],
            'body' => $json 
        ]);
        $data =(string) $response->getBody();
        
        return $data;
    }

    public static function setLocation($data){
        $data = json_decode($data);
        setcookie("requestId", $data->requestId, time()+3600); 
        header('Location: '.$data->processUrl);
        exit;
    }

    public static function getOrder($requestId){
        $nonce   = Str::random(16);
        $seed    = date('Y-m-d\TH:i:sP');
        $trankey = base64_encode(sha1($nonce.$seed.'024h1IlD', true));
        $nonce   = base64_encode($nonce);

        $json = json_encode(
            [
                'auth' => [
                    'login'   => '6dd490faf9cb87a9862245da41170ff2',
                    'tranKey' => $trankey,
                    'nonce'   => $nonce,
                    'seed'    => $seed
                ]
            ]);

        $client = new Client();
        $response = $client->request('POST', 'https://dev.placetopay.com/redirection/api/session/'.$requestId, [
            'headers' => [
                'Content-Type'     => 'application/json',
            ],
            'body' => $json 
        ]);

        $data =(string) $response->getBody();
        $data = json_decode($data);

        return $data->status->status;
    }

    
}