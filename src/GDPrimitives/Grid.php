<?php

namespace App\GDPrimitives;

use App\Constants\Con;
use App\Traits\ColorRegistryTrait;
use App\Traits\ConfigTrait;
use App\Lib\Region;
use App\Lib\TilePool;

class Grid
{

    use ConfigTrait;
    use ColorRegistryTrait;

    protected $defaultConfig = [
    ];

    /**
     * @var Color|null
     */
    protected $color = null;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Region
     */
    protected $region;
    protected $tiles;

    public function __construct(Region $region, $config = [])
    {
        $this->region = $region;
        $this->config = array_merge($this->defaultConfig, $config);
        $this->color = $this->getConfig('grid_color', $this->_getColor('grid'));
    }

    /**
     * @param int $n grid increment
     * @return float|int
     */
    public function getX($n)
    {
        return ($n * $this->region->tileSize()) + $this->region->origin(Con::X);
    }

    /**
     * @param int $n grid increment
     * @return float|int
     */
    public function getY($n)
    {
        return ($n * $this->region->tileSize()) + $this->region->origin(Con::Y);
    }

    /**
     * @param Region $region
     * @param Grid $grid
     * @return void
     */
    public function add($canvas): void
    {
        imagesetthickness($canvas,5);
        foreach (range(0, $this->region->width(Con::TILE)) as $i => $x) {
            $this->xLine($i)->add($canvas);
        }
        foreach (range(0, $this->region->height(Con::TILE)) as $i => $y) {
            $this->yLine($i)->add($canvas);
        }
    }

    public function getTiles()
    {
        if(is_null($this->tiles)) {
            $this->tiles = new TilePool($this);
        }
        return $this->tiles;
    }

    public function region()
    {
        return $this->region;
    }

    private function xLine($x)
    {
        $p1 = new Point(
            $this->getX($x),
            $this->getY(0)
        );
        $p2 = new Point(
            $this->getX($x),
            $this->getY($this->region->height(Con::TILE))
        );
        return new Line($p1, $p2, $this->_getColor('current'));
    }

    private function yLine($y)
    {
        $p1 = new Point(
            $this->getX(0),
            $this->getY($y)
        );
        $p2 = new Point(
            $this->getX($this->region->width(Con::TILE)),
            $this->getY($y)
        );
        return new Line($p1, $p2, $this->_getColor('current'));
    }

    public function setColor($alias, $specs): Grid
    {
        $this->color = $this->_setColor($alias, $specs);
        return $this;
    }

}
