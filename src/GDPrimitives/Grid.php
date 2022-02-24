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

    public function xLine($x)
    {
        $p1 = new Point($this->tile * $x + $this->pt1->x(), $this->pt1->y());
        $p2 = new Point($this->tile * $x + $this->pt1->x(), $this->pt2->y());
        return new PointPair($p1, $p2);
    }
}
