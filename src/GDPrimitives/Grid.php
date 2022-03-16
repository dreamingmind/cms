<?php

namespace App\GDPrimitives;

use App\Constants\Con;
use App\Lib\ColorRegistry;
use App\Traits\ConfigTrait;
use App\Lib\Region;
use App\Lib\TilePool;

class Grid
{

    use ConfigTrait;

    protected $defaultConfig = [
    ];
    /**
     * @var array
     */
    protected $config;
    /**
     * @var Region
     */
    protected $region;
    protected $tiles;
    /**
     * @var ?Color
     */
    protected $stroke_color;

    public function __construct(Region $region, $config = [])
    {
        $this->region = $region;
        $this->config = array_merge($this->defaultConfig, $config);
        $this->stroke_color = ColorRegistry::get('grid');
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
    public function draw($canvas): void
    {
        imagesetthickness($canvas,1);
        foreach (range(0, $this->region->width(Con::TILE)) as $i => $x) {
            $this->xLine($i)->draw($canvas);
        }
        foreach (range(0, $this->region->height(Con::TILE)) as $i => $y) {
            $this->yLine($i)->draw($canvas);
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
        return new Line($p1, $p2, $this->stroke_color);
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
        return new Line($p1, $p2, $this->stroke_color);
    }

    public function setColor(Color $stroke_color)
    {
        $this->stroke_color = $stroke_color;
    }

    public function getColor() : Color
    {
        return $this->stroke_color;
    }

}
