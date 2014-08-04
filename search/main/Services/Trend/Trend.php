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
           $keywords = array_merge($keywords, $trender->getLiveTopTenKeywords());
        }

        return $keywords;
    }

    public function getTopTenNewsInLive()
    {
        $news = array();
        foreach ($this->getTrendHandler()->getTrenders() as $trender) {
            $news = array_merge($news, $trender->getLiveTopTenNews());
        }

        return $news;
    }
}
