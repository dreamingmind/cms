<?php

namespace App\Strategies;

use App\GDPrimitives\Grid;
use App\Lib\Region;

class StrategyTwo
{

    public function __construct($config)
    {
        $region = new Region($config);
        $grid = (new Grid($region))
            ->_setColor('redish', [199, 66, 22]);

        $this->_canvas = $region->image();
        $grid->add($region->image());

    }

    public function output()
    {
        header('Content-Type: image/png');
        imagejpeg($this->_canvas, WWW_ROOT.'img/dungeon.png');
        imagedestroy($this->_canvas);
    }

}
