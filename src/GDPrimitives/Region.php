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

    /**
     * @var array
     */
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

    /**
     * @param string $axis Con::X or Con::Y
     * @return int
     */
    public function origin($axis) : int
    {
        $axis = $axis === Con::X ? 'origin_x' : 'origin_y';
        return $this->getConfig($axis, 0);
    }

    /**
     * @param string $unit Con::TILE or Con::PIXEL
     * @return int
     */
    public function width(string $unit) : int
    {
        $axis = $this->getConfig('tiles_wide');
        return $this->size($unit, $axis);
    }

    /**
     * @param string $unit Con::TILE or Con::PIXEL
     * @return int
     */
    public function height(string $unit) : int
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
            $this->origin(Con::X),
            $this->origin(Con::Y),
            $this->_getColor('current')->allocate($this->_canvas)
        );
        return $this->_canvas;
    }

    public function add($canvas)
    {
        imagefilledrectangle(
            $canvas,
            $this->origin(Con::X),
            $this->origin(Con::Y),
            $this->origin(Con::X) + $this->width(Con::PIXEL),
            $this->origin(Con::Y) + $this->height(Con::PIXEL),
            $this->getConfig('ground_color')->allocate($canvas)
        );
    }


}
