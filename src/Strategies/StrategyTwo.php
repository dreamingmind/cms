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
        $region->grid()
            ->setColor('redish', [199, 66, 22]);

        $this->_canvas = $region->image();
        $region->grid()->add($region->image());
        $tilePool = $region->grid()->getTiles();

        while ($tilePool->plentyOfSpace()) {
            $rm = $this->makeIsolatedRoom($tilePool, $region);
            $rm->add($region->image(), $region->grid()->getTiles());
        }
//        (new Room($region))->add($region->image(), $grid->getTiles());

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
        $existingBufferTiles = $tilePool->bufferTiles();

        do {
            $room = new Room($region);
            $inUse = collection($room->tiles())
                ->filter(function($tile, $key) use ($existingRoomTiles, $existingBufferTiles) {
                    return array_key_exists($key, $existingRoomTiles)
                        || array_key_exists($key, $existingBufferTiles);
                })
                ->toArray();
        } while (!empty($inUse));

        return $room;
    }


}
