<?php

namespace App\GDPrimitives;

use App\Lib\ConfigTrait;

class Grid
{

    use ConfigTrait;

    protected $defaultConfig = [
        'grid_color' => null,
    ];

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
        $this->setConfig(
            'grid_color',
            $this->getConfig(
                'grid_color',
                (new Color())->grey(50)
            )
        );
    }

    public function color() : Color
    {
        return $this->getConfig('grid_color');
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
    private function getX($n)
    {
        return $n * $this->region->tileSize();
    }

    /**
     * @param int $n grid increment
     * @return float|int
     */
    private function getY($n)
    {
        return $n * $this->region->tileSize();
    }
}
