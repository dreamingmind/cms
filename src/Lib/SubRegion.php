<?php

namespace App\Lib;

use App\Constants\Con;
use App\Exceptions\BadConstructorValueException;
use App\Traits\TileSizeTrait;

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

    public function __construct($config = [])
    {
        $this->config = array_merge($this->defaultConfig, $config);
        $this->canvas = $this->getConfig('canvas', false);
        if (!($this->canvas() instanceof Canvas)){
            $msg = 'Missing App\Lib\Canvas object in config[canvas]';
            throw new BadConstructorValueException($msg);
        }
        $this->config = array_merge($this->defaultConfig, $config);
        parent::__construct($config);
    }

    public function draw($grid = true)
    {
        $image = $this->image();
        imagefilledrectangle(
            $image,
            $this->origin(Con::X),
            $this->origin(Con::Y),
            $this->origin(Con::X) + $this->width(Con::PIXEL),
            $this->origin(Con::Y) + $this->height(Con::PIXEL),
            $this->getColor('fill')->allocate($image)
        );
        if ($grid) {
            $this->grid()->draw($image);
        }
        return $this->image();
    }

    /**
     * Get the configured or inherited Tile size in pixels
     *
     * @return int
     */
    public function tileSize(): int
    {
        return $this->getConfig('tile_size', parent::tileSize()) ;
    }

    /**
     * Get upper-left x or y coordinate as a pixel value
     *
     * Region origins are stored as pixel values rather than
     * Tile indexes because there is no guarantee that a region
     * will start at a Tile point on the containing Canvas/Region
     * nor that there is any relationship between the containing
     * and local grid.
     *
     * @param string $axis Con::X or Con::Y
     * @return int
     */
    public function origin(string $axis): int
    {
        $axis = $axis === Con::X ? 'origin_x' : 'origin_y';
        return $this->getConfig($axis, parent::origin($axis)) ;
    }

    public function width(string $unit): int
    {
        $tileCount = $this->getConfig('tiles_wide');
        if(!is_null($tileCount)) {
            return $this->size($unit, $tileCount);
        }
        return parent::width($unit);
    }

    public function height(string $unit): int
    {
        $tileCount = $this->getConfig('tiles_high');
        if(!is_null($tileCount)) {
            return $this->size($unit, $tileCount);
        }
        return parent::width($unit);
    }

}
