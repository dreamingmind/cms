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
    public $canvas;

    public function __construct($config = [])
    {
        if(is_null($this->canvas)) {
            $c = $config['canvas'];
            unset($config['canvas']);
            $this->canvas = new Canvas($config);
        }
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
}
