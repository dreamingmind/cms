<?php

namespace App\Lib;

use App\Constants\Con;
use App\GDPrimitives\Color;
use App\Traits\ColorRegistryTrait;
use App\Traits\ConfigTrait;
use App\Traits\TileSizeTrait;

/**
 * Canvas Class
 *
 * Establishes the overall size and tile size for an image.
 * The Canvas will always have an origin of 0,0 at the upper
 * left corner. The lower right coordinate will be calculated
 * form `tile` counts * tile size.
 *
 * The Tile system is further defined and implemented by
 * Grid, which acts as a decorator to Canvas.
 *
 * Canvas as the base for all regions (smaller rectangular areas).
 *
 * Rather than dealing with absolute coordinates at every stage,
 * this class defines the graphic in terms of tiles.
 * The tile size is provided, along with the count of tiles
 * in the `x` and `y` directions (tiles_wide and tiles_high).
 *
 * From this foundation, all our operations can work with tiles
 * as the unit of rendering. All the crazy absolute coordinates
 * for drawing graphics will be hidden away.
 */
class Canvas
{
    use ConfigTrait;
    use ColorRegistryTrait;
    use TileSizeTrait;

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
    protected $color;
    /**
     * @var false|\GdImage|resource
     */
    private $image;

    public function __construct($config = [])
    {
        $this->config = array_merge($this->defaultConfig, $config);
        $this->color = $this->getConfig('ground_color', $this->_getColor('ground'));
    }

    /**
     * @return int
     */
    public function tileSize(): int
    {
        return $this->getConfig('tile_size');
    }

    /**
     * Canvas origin is locked to 0,0
     *
     * @param string $axis Con::X or Con::Y
     * @return int
     */
    public function origin(string $axis) : int
    {
        return 0;
    }

    /**
     * @param string $unit Con::TILE or Con::PIXEL
     * @return int
     */
    public function width(string $unit) : int
    {
        $tileCount = $this->getConfig('tiles_wide');
        return $this->size($unit, $tileCount);
    }

    /**
     * @param string $unit Con::TILE or Con::PIXEL
     * @return int
     */
    public function height(string $unit) : int
    {
        $tileCount = $this->getConfig('tiles_high');
        return $this->size($unit, $tileCount);
    }

    public function image()
    {
        if (is_null($this->image)) {
            $this->image = imagecreatetruecolor(
                $this->width(Con::PIXEL),
                $this->height(Con::PIXEL)
            );
            imagefill(
                $this->image,
                $this->origin(Con::X),
                $this->origin(Con::Y),
                $this->_getColor('current')->allocate($this->image)
            );
        }
        return $this->image;
    }

}
