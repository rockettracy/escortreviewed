<?php
namespace SearchTime\Services\Trend;

use SearchTime\Services\Trend\TrendHandler;

class Trend
{
    private $trendHandler;

    /**
     * @return \SearchTime\Services\TrendHandler
     */
    private function getTrendHandler()
    {
        return $this->trendHandler;
    }

    public function __construct(TrendHandler $trendHandler)
    {
        $this->trendHandler = $trendHandler;
    }

    public function getTopTenKeywordsInLive()
    {
        $keywords = array();
        foreach ($this->getTrendHandler()->getTrenders() as $trender) {
           $keywords += $trender->getLiveTopTenKeywords();
        }

        return $keywords;
    }

    public function getTopTenKeywordsInWeek()
    {

    }
}
