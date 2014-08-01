<?php
namespace SearchTime\Utils;

class Guzzle
{
    public function __construct()
    {

    }

    public function getClient()
    {
        return new \GuzzleHttp\Client();
    }
}
