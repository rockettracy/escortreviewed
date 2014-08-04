<?php
namespace SearchTime\Services\Trend;

abstract class Trender
{
    const NUMBER = 10;

    public function __construct()
    {
    }

    abstract public function getLiveTopTenKeywords();
    abstract public function getLiveTopTenNews();
}
