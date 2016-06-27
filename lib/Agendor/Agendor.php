<?php
namespace W6\Agendor;

abstract class Agendor
{
    public static $api_key;
    const LIVE = 1;
    const ENDPOINT = "https://api.agendor.com.br";
    const API_VERSION = '1';

    public static function fullApiUrl($path)
    {
        return self::ENDPOINT . '/' . self::API_VERSION . $path;
        // return self::ENDPOINT . $path;
    }

    public static function setApiKey($api_key)
    {
        self::$api_key = $api_key;
    }

    public static function getApiKey()
    {
        return self::$api_key;
    }
}
