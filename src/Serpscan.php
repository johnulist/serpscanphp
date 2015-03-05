<?php

namespace OceanApplications\Serpscan;

class Serpscan {

    private $baseUrl = "https://serpscan.com/api/v1/";

    private $api_key;

    function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function getWebsites()
    {
        $url = $this->baseUrl."websites?token=".$this->api_key;
        return json_decode($this->curl_get($url));
    }

    private function curl_get($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Ruby');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}

