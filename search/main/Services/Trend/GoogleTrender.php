<?php
namespace SearchTime\Services\Trend;

use SearchTime\Utils\Curl;

class GoogleTrender extends Trender
{
    const URL = 'http://www.google.com/trends/hottrends/atom/feed?pn=p1';
    const NUMBER = 10;

    public function getLiveTopTenKeywords()
    {
        $response = Curl::send($this->getUrl());

        return array_slice($this->parse($response), 0, self::NUMBER);
    }

    private function parse($response)
    {
        $xml = new \SimpleXmlElement($response);

        $keywords = array();
        foreach ($xml->channel->item  as $value) {
            $keywords[] = $value->title;
        }

        return $keywords;
    }

    public function getWeekTopTenKeywords()
    {

    }

    private function getUrl()
    {
        return self::URL;
    }
}
