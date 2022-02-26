<?php

namespace App\Lib;

use App\GDPrimitives\Grid;
use App\GDPrimitives\Tile;

class TilePool
{

    /**
     * @var Grid
     */
    private $grid;
    /**
     * @var Tile[]
     */
    private $tiles;

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
        return collection(range(1, $this->grid()->region()->tilesWide()))
            ->reduce(function($accum, $xIndex) {
                collection(range(1, $this->grid()->region()->tilesHigh()))
                    ->reduce(function($accum, $yIndex) use ($xIndex) {
                        $t = new Tile($xIndex, $yIndex, $this->grid());
                        $accum[$t->getId()] = $t;
                        return $accum;
                    }, $accum);
                $accum = array_merge($accum, $column);
                return $accum;
            }, $this->tiles);
    }

    public function grid()
    {
        return $this->grid;
    }
}
