<?php

namespace App\Lib;


use App\Constants\Con;
use App\GDPrimitives\Point;
use App\GDPrimitives\PointPair;
use App\Interfaces\PointPairInterface;
use App\Interfaces\RegionInterface;

/**
 * Region class defines a rectangular area of operation
 *
 *
 */
class Region implements RegionInterface, PointPairInterface
{

    use ColorRegistryTrait;
    use ConfigTrait;

    /**
     * @var Canvas
     */
    public $canvas;
    /**
     * @var PointPair
     */
    private $pts;

    public function __construct($config = [])
    {
        if(is_null($this->canvas)) {
//            $c = $config['canvas'];
//            unset($config['canvas']);
            $this->canvas = new Canvas($config);
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
}
