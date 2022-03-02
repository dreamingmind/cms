<?php

namespace App\Controller;

use App\Strategies\StrategyOne;

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
}
