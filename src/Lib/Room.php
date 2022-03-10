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
    private $bufferTiles = [];

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
        //-1 keeps result from touching the right/bottom region boundaries
        $x = $this->region->width(Con::TILE) - $this->wide - 1;
        $y = $this->region->height(Con::TILE) - $this->high - 1;
        //start at 2 keeps result from touching left/top region boundaries
        $this->x_origin = rand(2, $x);
        $this->y_origin = rand(2, $y);

        /**
         * note proposed room tiles
         * They can be rule-checked. ::add() will record them in the TilePool
         */
        foreach (range($this->x_origin, $this->x_origin + $this->wide) as $x) {
            foreach (range($this->y_origin, $this->y_origin + $this->high) as $y) {
                $this->tiles["$x-$y"] = null;
            }
        }
        /**
         * note proposed buffer tiles
         * ::add() will record them in TilePool
         */
        foreach (range($this->x_origin - 1, $this->x_origin + $this->wide + 1) as $x) {
            foreach (range($this->y_origin - 1, $this->y_origin + $this->high + 1) as $y) {
                $key = "$x-$y";
                if (!array_key_exists($key, $this->tiles)) {
                    $this->bufferTiles[$key] = null;
                }
            }
        }
    }

    public function draw($canvas, TilePool $pool)
    {
//        $r = new Rectangle();
        foreach ($this->tiles as $key => $value) {
            list($x, $y) = explode('-', $key);
            $this->tiles[$key] = $pool->tile($x, $y);
            $pool->insertRoomTile($key);
            $this->rectangle->fill($canvas, $this->tiles[$key]);
        }
        foreach ($this->bufferTiles as $key => $value) {
            list($x, $y) = explode('-', $key);
            $this->bufferTiles[$key] = $pool->tile($x, $y);
            $pool->insertBufferTile($key);
        }
    }

    public function tiles()
    {
        return $this->tiles;
    }

    public function bufferTiles()
    {
        return $this->bufferTiles;
    }

}
