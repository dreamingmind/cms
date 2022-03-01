<?php

namespace App\Lib;

use App\Constants\Con;
use App\GDPrimitives\BadConstructorValueException;
use App\GDPrimitives\Color;

/**
 * SubRegion Class
 *
 * While a Region reflects exactly the specifications of a Canvas,
 * a SubRegion can carry its own origin, size, and scale settings.
 * The only requirement is that the SubRegion fit within the
 * containing Canvas/Region|SubRegion.
 *
 * SubRegions can also carry their own ground color
 *
 * They are useful whenever you want
 *   - to limit operations to a portion of the canvas
 *   - a different color-scheme for a portion of the canvas
 *   - a different grid scheme or scale for a portion of the canvas
 *
 * Insure your SubRegion is properly sized relative to the
 * containing Canvas/Region by using Region::newSubRegion()
 * or SubRegion::newRegion.
 *
 * Failure to do so may result in portions of your image
 * falling outside the final image boundaries.
 */
class SubRegion extends Region
{

    use TileSizeTrait;

    /**
     * @var array
     */
    protected $defaultConfig = [
        'origin_x' => null,
        'origin_y' => null,
        'tiles_wide' => null,
        'tiles_high' => null,
        'tile_size' => null,
        'ground_color' => null,
    ];
    /**
     * @var array
     */
    public $config = [];
    /**
     * @var Color $color
     */
    protected $color;

    public function __construct($config = [])
    {
        $this->config = array_merge($this->defaultConfig, $config);
        $this->color = $this->getConfig('ground_color', $this->_getColor('ground'));
        $this->canvas = $this->getConfig('canvas', false);
        if (!($this->canvas() instanceof Canvas)){
            $msg = 'Missing App\Lib\Canvas object in config[canvas]';
            throw new BadConstructorValueException($msg);
        }
        $this->config = array_merge($this->defaultConfig, $config);
        $this->color = $this->getConfig('ground_color', $this->_getColor('ground'));
//        parent::__construct($config);
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


    public function tileSize(): int
    {
        return $this->getConfig('tile_size', parent::tileSize()) ;
    }

    public function origin(string $axis): int
    {
        $axis = $axis === Con::X ? 'origin_x' : 'origin_y';
        return $this->getConfig($axis, parent::origin($axis)) ;
    }

    public function width(string $unit): int
    {
        $axis = $this->getConfig('tiles_wide');
        if(!is_null($this->getConfig($axis))) {
            return $this->size($unit, $axis);
        }
        return parent::width($axis);
    }

    public function height(string $unit): int
    {
        $axis = $this->getConfig('tiles_high');
        if(!is_null($this->getConfig($axis))) {
            return $this->size($unit, $axis);
        }
        return parent::width($axis);
    }

}
