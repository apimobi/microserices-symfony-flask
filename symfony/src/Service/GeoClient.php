<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class GeoClient
{
    
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::create();
    }
    
    /**
     * return latitude and longitude by giving a postal address
     */
    public function getLatLonByAddress(string $address): array
    {
        $res = $this->sendRequest('http://flask:5000/by-address/', $address);

        return ["lat" => $res['lat'], "lng" => $res['lng']];
    }

    /**
     * return latitude and longitude by giving an ip address
     */
    public function getLatLonByIp(string $ip): array
    {
        $res = $this->sendRequest('http://flask:5000/by-ip/', $ip);

        return ["lat" => $res['lat'], "lng" => $res['lng']];
    }

    private function sendRequest(string $url, string $str):array
    {
        $response = $this->client->request('GET', $url.urlencode($str));        
        $content = json_decode($response->getContent(), true);

        if(array_key_exists("lat", $content)) {
            return ["lat" => $content["lat"], "lng" => $content["lng"]];
        }
        
        return ["error" => $response->getStatusCode()];
    }

}