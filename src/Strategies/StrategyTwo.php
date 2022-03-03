<?php

namespace App\Strategies;

use App\GDPrimitives\Grid;
use App\Lib\Region;
use App\Lib\Room;

class StrategyTwo
{

    public function __construct($config)
    {
        $region = new Region($config);
        $grid = (new Grid($region))
            ->_setColor('redish', [199, 66, 22]);

        $this->_canvas = $region->image();
        $grid->add($region->image());

        foreach (range(0,5) as $count) {
            $room = new Room($grid->region());
            $colors = $this->randomColor();
            $room->_getRectangle('current')
                ->setColor('fill', implode($colors), $colors);
            $room->add($region->image(), $grid->getTiles());
        }


    }

    public function output()
    {
        header('Content-Type: image/png');
        imagejpeg($this->_canvas, WWW_ROOT.'img/dungeon.png');
        imagedestroy($this->_canvas);
    }

    private function randomColor()
    {
        return [rand(0,255), rand(0,255), rand(0,255)];
    }


}
