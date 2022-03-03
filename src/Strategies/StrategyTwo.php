<?php

namespace App\Strategies;

use App\GDPrimitives\Grid;
use App\Lib\Region;
use App\Lib\Room;
use App\Lib\TilePool;

class StrategyTwo
{

    public function __construct($config)
    {
        $region = new Region($config);
        $grid = (new Grid($region))
            ->_setColor('redish', [199, 66, 22]);

        $this->_canvas = $region->image();
        $grid->add($region->image());

//        foreach (range(0,5) as $count) {
//            $room = new Room($grid->region());
//            $colors = $this->randomColor();
//            $room->_getRectangle('current')
//                ->setColor('fill', implode($colors), $colors);
//            $room->add($region->image(), $grid->getTiles());
//        }
        $tilePool = $grid->getTiles();

        while ($tilePool->plentyOfSpace()) {
            $colors = $this->randomColor();
            $rm = $this->makeIsolatedRoom($tilePool, $grid->region());
            $rm->_getRectangle('current')
                ->setColor('fill', implode($colors), $colors);
            $rm->add($region->image(), $grid->getTiles());
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

    private function makeIsolatedRoom(TilePool $tilePool, Region $region)
    {
        $existingRoomTiles = $tilePool->roomTiles();

        do {
            $room = new Room($region);
            $inUse = collection($room->tiles())
                ->filter(function($tile, $key) use ($existingRoomTiles) {
                    return array_key_exists($key, $existingRoomTiles);
                })
                ->toArray();
        } while (!empty($inUse));

        return $room;
    }


}
