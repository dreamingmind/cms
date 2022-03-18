<?php

namespace App\Controller;

use App\GDPrimitives\HexGrid;
use App\Strategies\StrategyOne;
use App\Strategies\StrategyTwo;
use App\Strategies\ReplHex;
use Psy\Util\Str;

class DungeonsController extends AppController
{

    public function view()
    {

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
//            'grid' => HexGrid::class,
            'tiles_wide' => 50,
            'tiles_high' => 25,
            'tile_size' => 70,
        ]);
        $Canvas->output();
    }

    public function hex()
    {
        $canvas = new StrategyTwo([
            'grid' => HexGrid::class,
            'tiles_wide' => 100,
            'tiles_high' => 50,
            'tile_size' => 70
        ]);
        $canvas->output();
        $this->render('dun');
    }
}
