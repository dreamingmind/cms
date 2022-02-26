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
        $grid = (new Grid($region));
        $grid->_setColor('black', ['grey' => 100]);
//        $grid->_setColor('black', );
        $r = new Rectangle();
        $r->setColor('stroke', 'red', [255, 0, 0]);

        $this->_canvas = $region->canvas();

//        /* @var Tile $t */
//        $t = $tiles['2-2'];
//        $t->stroke($this->_canvas, 10);
//
//        /* @var Tile $t */
//        $t = $tiles['1-1'];
//        $r->stroke($this->_canvas, $t->points()->pair(), 7);
//
//        $points = [$t->points()->center(), $t->points()->center()];
//        $r->stroke($this->_canvas, $points,7);

        $tiles = $grid->getTiles();
        foreach(range(1, 1000) as $c) {
            $xi = rand(1, $region->tilesWide());
            $yi = rand(1, $region->tilesHigh());
            /* @var Tile $t */
            $t = $tiles["$xi-$yi"];
//            $p = $t->points()->center();
//            $r->stroke($this->_canvas, $t->points()->pair(), 7);

            $r->fill($this->_canvas, $t);
//            $r->fill($this->_canvas, $t->points()->pair()[0], $t->points()->pair()[1]);
        }

        $grid->add($this->_canvas);

//        debug($this->_getColor());

//        $this->subRegion($region, $grid);
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
