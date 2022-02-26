<?php

namespace App\GDPrimitives;

use App\Lib\ColorRegistry;
use App\Lib\ColorRegistryTrait;
use Migrations\ConfigurationTrait;

class Canvas
{

    use ColorRegistryTrait;

    protected $defaultConfig = [
        'tiles_wide' => 50,
        'tiles_high' => 25,
        'tile' => 70,
    ];

    public function __construct($config)
    {
        $region = new Region($config);
        $grid = new Grid($region);
        $tiles = $grid->getTiles();

        $this->_canvas = $region->canvas();
        /* @var Tile $t */
        $t = $tiles['2-2'];
        $t->stroke($this->_canvas, 1);

        /* @var Tile $t */
        $t = $tiles['1-1'];
        $t->stroke(
            $this->_canvas,
            7,
            $this->setColor('1-1', [0,200, 255])
        );

        $points = [$t->points()->getPoint(50,50), $t->points()->getPoint(50,50)];
        $r = new Rectangle();
        $r->stroke($this->_canvas, $points,7);
        debug($this->getColor());


        $grid->add($this->_canvas);

        $this->subRegion($region, $grid);
    }

    public function get()
    {
        return $this->_canvas;
    }

    public function output()
    {
        header('Content-Type: image/png');
        imagejpeg($this->_canvas, WWW_ROOT.'img/dungeon.png');
        imagedestroy($this->_canvas);
    }

    private function subRegion(Region $region, Grid $grid)
    {
        $x = rand(0, $region->tilesWide()/2);
        $y = rand(0, $region->tilesHigh()/2);

        $config = [
            'tile_size' => (int) $region->tileSize() / 2,
            'origin_x' => (int) $grid->getX($x),
            'origin_y' => (int) $grid->getY($y),
            'ground_color' => (new Color())->grey(100),
            'tiles_wide' => $region->tilesWide(),
            'tiles_high' => $region->tilesHigh(),
        ];

        $subRegion = new Region($config);
        $subGrid = new Grid($subRegion, ['grid_color' => (new Color())->setColor(0, 127, 127)]);

        $subRegion->add($this->_canvas);
        $subGrid->add($this->_canvas);

    }

}
