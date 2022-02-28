<?php

namespace App\GDPrimitives;

use App\Constants\Con;
use App\Lib\ColorRegistryTrait;
use App\Lib\ConfigTrait;
use App\Lib\Canvas;

/**
 * Region class defines a rectangular area of operation
 *
 *
 */
class Region /*extends Canvas*/
{

    use ConfigTrait;
    use ColorRegistryTrait;

    protected $defaultConfig = [
        'origin_x' => 0,
        'origin_y' => 0,
        'tiles_wide' => 50,
        'tiles_high' => 25,
        'tile_size' => 70,
        'ground_color' => null,
    ];
    /**
     * @var array
     */
    public $config = [];

    /**
     * @var Color $color
     */
    public $color;

    public function __construct($config = [])
    {
        $this->config = array_merge($this->defaultConfig, $config);
        $this->color = $this->getConfig('ground_color', $this->_getColor('ground'));
    }

    public function tileSize()
    {
        return $this->getConfig('tile_size');
    }

    public function x($percent)
    {
        return (int) ($this->width(Con::PIXEL) * ($percent / 100));
    }

    public function y($percent)
    {
        return (int) ($this->height(Con::PIXEL) * ($percent / 100));
    }

    /**
     * @param string $unit
     * @return int
     */
    public function width(string $unit)
    {
        $axis = $this->getConfig('tiles_wide');
        return $this->size($unit, $axis);
    }

    /**
     * @param string $unit
     * @return int
     */
    public function height(string $unit)
    {
        $axis = $this->getConfig('tiles_high');
        return $this->size($unit, $axis);
    }

    /**
     * @param string $unit
     * @param string $axis
     * @return float|int|mixed
     */
    private function size(string $unit, string $axis)
    {
        return $unit === Con::TILE
            ? $axis
            : ($axis * $this->getConfig('tile_size')) + 1;
    }

    public function canvas()
    {
        $this->_canvas = imagecreatetruecolor(
            $this->width(Con::PIXEL),
            $this->height(Con::PIXEL)
        );
        imagefill(
            $this->_canvas,
            $this->getConfig('origin_x'),
            $this->getConfig('origin_y'),
            $this->_getColor('current')->allocate($this->_canvas)
        );
        return $this->_canvas;
    }

    public function tilesHigh()
    {
        return $this->getConfig('tiles_high');
    }

    public function tilesWide()
    {
        return $this->getConfig('tiles_wide');
    }

    public function add($canvas)
    {
        imagefilledrectangle(
            $canvas,
            $this->getConfig('origin_x'),
            $this->getConfig('origin_y'),
            $this->getConfig('origin_x') + $this->width(Con::PIXEL),
            $this->getConfig('origin_y') + $this->height(Con::PIXEL),
            $this->getConfig('ground_color')->allocate($canvas)
        );
    }

    public function originX()
    {
        return $this->getConfig('origin_x');
    }

    public function originY()
    {
        return $this->getConfig('origin_y');
    }

}
