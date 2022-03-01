<?php

namespace App\Lib;


/**
 * Region class defines a rectangular area of operation
 *
 *
 */
class Region implements RegionInterface
{

    use ColorRegistryTrait;
    use ConfigTrait;

    /**
     * @var Canvas
     */
    private $canvas;

    public function __construct($config = [])
    {
        $this->canvas = new Canvas($config);
    }

    public function canvas(): Canvas
    {
        return $this->canvas;
    }

    public function newSubRegion($x, $y, $w, $h): SubRegion
    {
        return new SubRegion([
            'origin_x' => $x,
            'origin_y' => $y,
            'tiles_wide' => $w,
            'tiles_high' => $h,
        ]);
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
}
