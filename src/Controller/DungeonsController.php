<?php

namespace App\Controller;

use App\Strategies\StrategyOne;
use App\Strategies\StrategyTwo;

class DungeonsController extends AppController
{

    public function view()
    {
        $this->viewBuilder()->setLayout('ajax');
    }

    public function dun()
    {
        $Canvas = new StrategyOne([
            'tiles_wide' => 150,
            'tiles_high' => 80,
            'tile_size' => 70,
        ]);
        $Canvas->output();
    }

    public function dun2()
    {
        $Canvas = new StrategyTwo([
            'tiles_wide' => 50,
            'tiles_high' => 25,
            'tile_size' => 70,
        ]);
        $Canvas->output();
    }
}
