<?php
namespace SearchTime\Services\Trend;

use SearchTime\Utils\Curl;

class YahooTrender extends Trender
{
    const URL = 'https://ca.news.yahoo.com/world--most-popular/most-popular/1.html';
    const NUMBER = 10;

    public function getLiveTopTenKeywords()
    {
        return array();
    }

    private function parse($response)
    {
        $news = array();
        $index = 1;

        $dom = new \DOMDocument();
        $response = preg_replace('/^<!DOCTYPE.+?>/', '', $response);
        @$dom->loadHTML($response);

        $xpath = new \DOMXPath($dom);
        $links = $xpath->query('//ul[contains(@class,"most-popular-ul")]//li//h4/a');
        foreach ($links as $link) {
            $news[] = array(
                'index' => $index,
                'headline' => $link->nodeValue,
                'link' => $this->getNewsLinkPrefix() . $link->getAttribute('href')
            );
            $index++;
        }

        return $news;
    }

    private function getNewsLinkPrefix()
    {
        return 'https://ca.news.yahoo.com';
    }

    public function getLiveTopTenNews()
    {
        $response = Curl::send($this->getUrl());

        return array_slice($this->parse($response), 0, self::NUMBER);
    }

    private function getUrl()
    {
        return self::URL;
    }
}
