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
    private $tiles = [];

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
        collection(range(1, $this->grid()->region()->tilesWide()))
            ->reduce(function($accum, $xIndex) {
                collection(range(1, $this->grid()->region()->tilesHigh()))
                    ->reduce(function($accum, $yIndex) use ($xIndex) {
                        $t = new Tile($xIndex, $yIndex, $this->grid());
                        $this->tiles[$t->getId()] = $t;
                    }, []);
            }, $this->tiles);
    }

    public function grid(): Grid
    {
        return $this->grid;
    }

    public function tiles(): array
    {
        return $this->tiles;
    }

    public function tile(int $xi, int $yi): Tile
    {
        return $this->tiles[$this->key($xi, $yi)];
    }

    public function key(int $xi, int $yi): string
    {
        return "$xi-$yi";
    }
}