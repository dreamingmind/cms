<?php

namespace App\GDPrimitives;

use App\Lib\ColorRegistryTrait;
use App\Lib\ConfigTrait;
use Cake\Utility\Hash;

class Region
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
        $this->color = $this->getConfig('ground_color', $this->getColor('ground'));
    }

    public function tileSize()
    {
        return $this->getConfig('tile_size');
    }

    public function x($percent)
    {
        return (int) ($this->width() * ($percent / 100));
    }

    public function y($percent)
    {
        return (int) ($this->height() * ($percent / 100));
    }

    public function width()
    {
        return ($this->getConfig('tiles_wide') * $this->getConfig('tile_size')) + 1;
    }

    public function height()
    {
        return ($this->getConfig('tiles_high') * $this->getConfig('tile_size')) + 1;
    }

    public function canvas()
    {
        $this->_canvas = imagecreatetruecolor(
            $this->width(),
            $this->height()
        );
        imagefill(
            $this->_canvas,
            $this->getConfig('origin_x'),
            $this->getConfig('origin_y'),
            $this->getColor('current')->allocate($this->_canvas)
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
            $this->getConfig('origin_x') + $this->width(),
            $this->getConfig('origin_y') + $this->height(),
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
