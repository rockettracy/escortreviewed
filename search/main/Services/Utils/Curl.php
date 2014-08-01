<?php
namespace SearchTime\Utils;

class Curl
{
    public static function send($url)
    {
        if (empty($url)) {
            return 'Error: No any input before curl.';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        return curl_exec($ch);
    }
}
