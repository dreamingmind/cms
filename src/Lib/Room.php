<?php

namespace App\Lib;

use App\GDPrimitives\Grid;
use App\GDPrimitives\PointPair;
use App\GDPrimitives\Rectangle;

class Room
{

    use TileSetTrait;

    private $max = 10;
    private $min = 3;
    private $tiles = [];

    private $wide;
    private $high;
    /**
     * @var int
     */
    private $x_origin;
    /**
     * @var int
     */
    private $y_origin;

    public function __construct($region)
    {
        $this->wide = rand($this->min, $this->max);
        $this->high = rand($this->min, $this->max);
        $this->region = $region;
        $this->assemble();
    }

    /**
     * @param string $dir 'width' or 'height'
     * @return int
     */
    public function room($dir)
    {
        return $this->$dir;
    }

    /**
     * @param string $axis 'x' or 'y'
     * @return int
     */
    public function origin($axis)
    {
        $property = "{$axis}_origin";
        return $this->$property;
    }

    public function assemble()
    {
        $x = $this->region->tilesWide() - $this->wide - 1;
        $y = $this->region->tilesHigh() - $this->high - 1;
        $this->x_origin = rand(2, $x);
        $this->y_origin = rand(2, $y);
    }

    public function add($canvas, TilePool $pool)
    {
        $r = new Rectangle();
        foreach (range($this->x_origin, $this->x_origin + $this->wide) as $x) {
            foreach (range($this->y_origin, $this->y_origin + $this->high) as $y) {
                $key = $this->key($x, $y);
                $this->tiles[$key] = $pool->tile($x, $y);
                $r->fill($canvas, $this->tiles[$key]);
            }
        }
    }

}
