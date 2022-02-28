<?php

namespace App\GDPrimitives;

use App\Constants\Con;
use App\Lib\ColorRegistryTrait;
use App\Lib\ConfigTrait;
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

    public function __construct(Region $region, $config = [])
    {
        $this->region = $region;
        $this->config = array_merge($this->defaultConfig, $config);
        $this->color = $this->getConfig('grid_color', $this->_getColor('grid'));
    }

    public function color() : Color
    {
        return $this->color;
    }

    public function xLine($x)
    {
        $p1 = new Point(
            $this->getX($x),
            $this->getY(0)
        );
        $p2 = new Point(
            $this->getX($x),
            $this->getY($this->region->height(Con::TILE))
        );
        return new Line($p1, $p2, $this->color());
    }

    public function yLine($y)
    {
        $p1 = new Point(
            $this->getX(0),
            $this->getY($y)
        );
        $p2 = new Point(
            $this->getX($this->region->width(Con::TILE)),
            $this->getY($y)
        );
        return new Line($p1, $p2, $this->color());
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
        foreach (range(0, $this->region->width(Con::TILE)) as $i => $x) {
            $this->xLine($i)->add($canvas);
        }
        foreach (range(0, $this->region->height(Con::TILE)) as $i => $y) {
            $this->yLine($i)->add($canvas);
        }
    }

    public function getTiles()
    {
        return new TilePool($this);
    }

    public function region()
    {
        return $this->region;
    }

}
