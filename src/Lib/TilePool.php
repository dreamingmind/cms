<?php

namespace App\Lib;

use App\Constants\Con;
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
    private $roomTiles = [];

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
        collection(range(1, $this->grid()->region()->width(Con::TILE)))
            ->reduce(function($accum, $xIndex) {
                collection(range(1, $this->grid()->region()->height(Con::TILE)))
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

    public function tile(int $x, int $y): Tile
    {
        return $this->tiles[$this->key($x, $y)];
    }

    public function key(int $x, int $y): string
    {
        return "$x-$y";
    }

    public function lowestX() {
        return collection($this->tiles())->min('x');
    }

    public function highestX()
    {
        return collection($this->tiles())->max('x');
    }

    public function lowestY()
    {
        return collection($this->tiles())->min('y');
    }

    public function higestY()
    {
        return collection($this->tiles())->max('y');
    }

    public function plentyOfSpace(): bool
    {
        $totalCount = count($this->tiles());
        $remaining = count($this->tiles()) - count($this->roomTiles);
        return $remaining > ($totalCount * .5);
    }

    public function insertRoomTile($key)
    {
        $this->roomTiles[$key] = $this->tiles[$key];
    }

}
