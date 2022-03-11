<?php

namespace App\Lib;


use App\Constants\Con;
use App\GDPrimitives\Grid;
use App\GDPrimitives\Point;
use App\GDPrimitives\PointPair;
use App\Interfaces\PointPairInterface;
use App\Interfaces\RegionInterface;
use App\Traits\ColorRegistryTrait;
use App\Traits\ConfigTrait;
use App\Traits\RectangleRegistryTrait;

/**
 * Region class defines a rectangular area of operation
 *
 *
 */
class Region implements RegionInterface, PointPairInterface
{

    use ColorRegistryTrait;
    use ConfigTrait;
    use RectangleRegistryTrait;

    /**
     * @var Canvas
     */
    public $canvas;
    /**
     * @var PointPair
     */
    private $pts;
    private $rectangle;
    protected $color = [];

    public function __construct($config = [])
    {
        if (($config['canvas'] ?? null) instanceof Canvas) {
            $this->canvas = $config['canvas'];
        }
        else {
            $this->canvas = new Canvas($config);
        }
        if (($config['grid'] ?? null) instanceof Grid) {
            $this->grid = $config['grid'];
        }
        else {
            $this->grid = new Grid($this);
        }
        $this->pts = new PointPair(
            new Point($this->origin(Con::X), $this->origin(Con::Y)),
            new Point($this->width(Con::PIXEL), $this->height(Con::PIXEL))
        );
    }

    public function canvas(): Canvas
    {
        return $this->canvas;
    }

    public function newSubRegion($config = []): SubRegion
    {
        $config['canvas'] = $this->canvas();
        return new SubRegion($config);
    }

    public function tileSize(): int
    {
        return $this->canvas()->tileSize();
    }

    public function origin(string $axis): int
    {
        return $this->canvas()->origin($axis);
    }

    public function width(string $unit): int
    {
        return $this->canvas()->width($unit);
    }

    public function height(string $unit): int
    {
        return $this->canvas()->height($unit);
    }

    public function image()
    {
        return $this->canvas()->image();
    }

    public function points(): PointPair
    {
        return $this->pts;
    }

    /**
     * Set this classes color in a chainable way
     *
     * @param string $type
     * @param $alias
     * @return $this
     */
    public function setColor(string $type, $alias): Region
    {
        $this->color = $this->canvas()->_setColor($type, $alias);
        return $this;
    }

    public function getColor($alias = null)
    {
        return $this->canvas()->_getColor($alias);
    }

    public function grid()
    {
        return $this->grid;
    }

    public function draw($grid = true)
    {
        $this->grid()->draw($this->image());
        return $this->image();
    }

}
