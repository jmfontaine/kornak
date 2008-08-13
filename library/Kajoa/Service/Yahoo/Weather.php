<?php
class Kajoa_Service_Yahoo_Weather
{
    const URL = 'http://weather.yahooapis.com/forecastrss?p=%s&u=%s';

    const TEMPERATURE_UNIT_CELSIUS    = 1;
    const TEMPERATURE_UNIT_FAHRENHEIT = 2;
    
    protected $_temperatureUnit = self::TEMPERATURE_UNIT_CELSIUS; 
    
    public function getCurrentWeather($code)
    {
        if (self::TEMPERATURE_UNIT_CELSIUS == $this->_temperatureUnit) {
            $temperatureUnit = 'c';
        } else {
            $temperatureUnit = 'f';
        }
    
        $url        = sprintf(self::URL, $code, $temperatureUnit);    
        $httpClient = new Zend_Http_Client($url);
        $response   = $httpClient->request();

        return new Kajoa_Service_Yahoo_WeatherResult($response->getBody());
    }
    
    public function setTemperatureUnit($unit)
    {
        $this->_temperatureUnit = $unit;
    }
}