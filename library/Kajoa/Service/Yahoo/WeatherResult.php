<?php
class Kajoa_Service_Yahoo_WeatherResult
{
    const NAMESPACE = 'http://xml.weather.yahoo.com/ns/rss/1.0';

    public $city;
    public $country;
    public $description;
    public $distanceUnit;
    public $language;
    public $lastBuildDate;
    public $link;
    public $pressureUnit;
    public $region;
    public $speedUnit;
    public $temperature;
    public $temperatureUnit;
    public $title;
    public $ttl;
    
    public function __construct($xml)
    {
        $document  = new DOMDocument();
        $document->loadXML($xml);

        $this->description   = $document->getElementsByTagName('description')->item(0)->nodeValue;
        $this->language      = $document->getElementsByTagName('language')->item(0)->nodeValue;
        $this->lastBuildDate = $document->getElementsByTagName('lastBuildDate')->item(0)->nodeValue;
        $this->link          = $document->getElementsByTagName('link')->item(0)->nodeValue;
        $this->title = $document->getElementsByTagName('title')->item(0)->nodeValue;
        $this->ttl   = $document->getElementsByTagName('ttl')->item(0)->nodeValue;

        $conditionNode     = $document->getElementsByTagNameNS(self::NAMESPACE, 'condition')->item(0);
        $this->temperature = $conditionNode->getAttribute('temp');
        
        $locationNode  = $document->getElementsByTagNameNS(self::NAMESPACE, 'location')->item(0);
        $this->city    = $locationNode->getAttribute('city');
        $this->country = $locationNode->getAttribute('country');
        $this->region  = $locationNode->getAttribute('region');
        
        $unitNode              = $document->getElementsByTagNameNS(self::NAMESPACE, 'units')->item(0);
        $this->distanceUnit    = $unitNode->getAttribute('distance');
        $this->pressureUnit    = $unitNode->getAttribute('pressure');
        $this->speedUnit       = $unitNode->getAttribute('speed');
        $this->temperatureUnit = $unitNode->getAttribute('temperature');
    }
}