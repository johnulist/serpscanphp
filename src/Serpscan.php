<?php

namespace OceanApplications\Serpscan;

class Serpscan {

    private $baseUrl = "https://serpscan.com/api/v1/";

    private $api_key;

    /**
     * @param $api_key API key is required for all requests
     */
    function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /** Get all Websites
     * @return mixed
     */
    public function getWebsites()
    {
        $url = $this->baseUrl."websites?token=".$this->api_key;
        return json_decode($this->curl_get($url));
    }

    /** Get website by ID
     * @param $websiteId to use for selecting website
     * @return mixed
     */
    public function getWebsite($websiteId)
    {
        $url = $this->baseUrl."websites/".$websiteId."?token=".$this->api_key;
        return json_decode($this->curl_get($url));
    }

    /** Get all keywords from website, includes rankings
     * @param $websiteId to use for selecting website
     * @return mixed
     */
    public function getKeywordsBySite($websiteId)
    {
        $url = $this->baseUrl."websites/".$websiteId."/keywords?token=".$this->api_key;
        return json_decode($this->curl_get($url));
    }

    /** Create new site to track SERP
     * @param $siteUrl URL of website to add to tracking
     * @return mixed
     */
    public function createWebsite($siteUrl)
    {
        $url = $this->baseUrl."websites?token=".$this->api_key;
        return json_decode($this->curl_post($url, array('website'=>array('url'=>$siteUrl))));
    }

    /** Create a keyword on site specified by siteId
     * @param $siteId of site to add keyword to
     * @param $keyword to add
     * @return mixed
     */
    public function createKeyword($siteId, $keyword)
    {
        $url = $this->baseUrl."keywords?token=".$this->api_key;
        return json_decode($this->curl_post($url, array('keyword'=>array('phrase'=>$keyword, 'website_id'=>$siteId))));
    }

    /** Delete website by ID
     * @param $websiteId of site to delete
     * @return array
     */
    public function deleteWebsite($websiteId)
    {
        $url = $this->baseUrl."websites/".$websiteId."?token=".$this->api_key;
        return $this->curl_delete($url);
    }

    /** Delete keyword from website by keyword ID
     * @param $keywordId of keyword to delete
     * @return array
     */
    public function deleteKeyword($keywordId)
    {
        $url = $this->baseUrl."keywords/".$keywordId."?token=".$this->api_key;
        return $this->curl_delete($url);
    }

    /**
     * @param $path URL to send HTTP GET request to
     * @return string JSON encoded response
     */
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

    /**
     * @param $path URL to send HTTP POST request to
     * @param $params array  HTTP POST parameters
     * @return string JSON encoded response
     */
    private function curl_post($path, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Ruby');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * @param $path URL to send HTTP DELETE request to
     * @return array Response and STATUS_CODE
     */
    private function curl_delete($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Ruby');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array("Response"=>json_decode($response), "STATUS_CODE"=>$httpCode);
    }

}

