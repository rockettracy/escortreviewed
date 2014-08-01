<?php
namespace SearchTime\Services\Trend;

abstract class Trender
{
    public function __construct()
    {
    }

    abstract public function getLiveTopTenKeywords();
    abstract public function getWeekTopTenKeywords();
}
