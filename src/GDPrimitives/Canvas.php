<?php

namespace App\GDPrimitives;

use App\Lib\ColorRegistry;
use App\Lib\ColorRegistryTrait;
use App\Lib\Room;
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
        $t = osdTime();
        $t->start();
        $region = new Region($config);
        $grid = (new Grid($region));
        $grid->_setColor('black', ['grey' => 100]);

        $this->_canvas = $region->canvas();
        $grid->add($this->_canvas);

//        $this->randomBlocks(
//            $grid,
//            new Rectangle()
//        );

        foreach (range(0,5) as $count) {
            $room = new Room($grid->region());
            $room->add($this->_canvas, $grid->getTiles());
        }

//        $this->subRegion($region, $grid);
        $t->end();
        osd($t->result());
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

        $this->randomBlocks($subGrid, new Rectangle());

    }

    /**
     * @param Grid $grid
     * @param Region $region
     * @param Rectangle $r
     * @return void
     */
    private function randomBlocks(Grid $grid, Rectangle $r): void
    {
        $pool = $grid->getTiles();
        foreach (range(1, 1000) as $c) {
            $xi = rand(1, $grid->region()->tilesWide());
            $yi = rand(1, $grid->region()->tilesHigh());
            /* @var Tile $t */
            $t = $pool->tile($xi, $yi);

            $r->fill($this->_canvas, $t);
        }
    }

}
