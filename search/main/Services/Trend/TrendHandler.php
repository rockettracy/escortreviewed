<?php
namespace SearchTime\Services\Trend;

use Silex\Application;

class TrendHandler
{
    private $trenders = array();

    /**
     * @return array
     */
    public function getTrenders()
    {
        return $this->trenders;
    }

    public function __construct()
    {
    }

    public function addTrender(Trender $trender)
    {
        $this->trenders[] = $trender;
    }
}
