<?php
namespace SearchTime\Services\Trend;

abstract class Trender
{
    private $client;

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    public function __construct($client)
    {
        $this->client = $client;
    }

    abstract public function getLiveTopTenKeywords();
    abstract public function getWeekTopTenKeywords();
}
