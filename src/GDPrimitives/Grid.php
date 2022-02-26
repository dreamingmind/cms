<?php

namespace App\GDPrimitives;

use App\Lib\ColorRegistryTrait;
use App\Lib\ConfigTrait;

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
        $this->color = $this->getConfig('grid_color', $this->getColor('grid'));
    }

    public function color() : Color
    {
        return $this->color;
    }

    public function xLine($x)
    {
        $p1 = new Point(
            $this->getX($x) + $this->region->originX(),
            $this->region->y(0) + $this->region->originY()
        );
        $p2 = new Point(
            $this->getX($x) + $this->region->originX(),
            $this->region->y(100) + $this->region->originY()
        );
        return new Line($p1, $p2, $this->color());
    }

    public function yLine($y)
    {
        $p1 = new Point(
            $this->region->x(0) + $this->region->originX(),
            $this->getY($y) + $this->region->originY()
        );
        $p2 = new Point(
            $this->region->x(100) + $this->region->originX(),
            $this->getY($y) + $this->region->originY()
        );
        return new Line($p1, $p2, $this->color());
    }

    /**
     * @param int $n grid increment
     * @return float|int
     */
    public function getX($n)
    {
        return $n * $this->region->tileSize();
    }

    /**
     * @param int $n grid increment
     * @return float|int
     */
    public function getY($n)
    {
        return $n * $this->region->tileSize();
    }

    /**
     * @param Region $region
     * @param Grid $grid
     * @return void
     */
    public function add($canvas): void
    {
        foreach (range(0, $this->region->tilesWide()) as $i => $x) {
            $xLine[] = $this->xLine($i);
            $xLine[$i]->add($canvas);
        }
        foreach (range(0, $this->region->tilesHigh()) as $i => $y) {
            $yLine[] = $this->yLine($i);
            $yLine[$i]->add($canvas);
        }
    }

    public function getTiles()
    {
        return collection(range(1, $this->region->tilesWide()))
            ->reduce(function($accum, $xIndex) {
                $column = collection(range(1, $this->region->tilesHigh()))
                    ->reduce(function($accum, $yIndex) use ($xIndex) {
                        $t = new Tile($xIndex, $yIndex, $this);
                        $accum[$t->getId()] = $t;
                        return $accum;
                    }, $accum);
                $accum = array_merge($accum, $column);
                return $accum;
            }, []);
    }

}
