<?php

namespace App\Lib;

use App\Constants\Con;
use App\GDPrimitives\Rectangle;
use App\Traits\RectangleRegistryTrait;

class Room
{

    use RectangleRegistryTrait;

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
    /**
     * @var Region
     */
    private $region;
    private $rectangle;

    public function __construct($region)
    {
        $this->wide = rand($this->min, $this->max);
        $this->high = rand($this->min, $this->max);
        $this->region = $region;
        $this->assemble();
        $this->rectangle = $this->_getRectangle('room');
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
        $x = $this->region->width(Con::TILE) - $this->wide - 1;
        $y = $this->region->height(Con::TILE) - $this->high - 1;
        $this->x_origin = rand(2, $x);
        $this->y_origin = rand(2, $y);

        foreach (range($this->x_origin, $this->x_origin + $this->wide) as $x) {
            foreach (range($this->y_origin, $this->y_origin + $this->high) as $y) {
                $this->tiles["$x-$y"] = null;
            }
        }
    }

    public function add($canvas, TilePool $pool)
    {
//        $r = new Rectangle();
        foreach ($this->tiles as $key => $value) {
            list($x, $y) = explode('-', $key);
                $this->tiles[$key] = $pool->tile($x, $y);
                $pool->insertRoomTile($key);
                $this->rectangle->fill($canvas, $this->tiles[$key]);
        }
    }

}
