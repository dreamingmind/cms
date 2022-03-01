<?php

namespace App\GDPrimitives;

use App\Constants\Con;
use App\Lib\ColorRegistryTrait;
use App\Lib\Region;
use App\Lib\Room;

class Canvas
{

    use ColorRegistryTrait;

    protected $defaultConfig = [
        'tiles_wide' => 50,
        'tiles_high' => 25,
        'tile' => 70,
    ];

    public function __construct($config = [])
    {
        $region = new Region(['canvas' => new \App\Lib\Canvas([])]);
        $grid = (new Grid($region))
            ->_setColor('redish', [199, 66, 22]);

        $this->_canvas = $region->image();
        $grid->add($this->_canvas);

        $this->randomBlocks(
            $grid,
            new Rectangle()
        );

        foreach (range(0,5) as $count) {
            $room = new Room($grid->region());
            $room->add($this->_canvas, $grid->getTiles());
        }

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
        $x = rand(0, $region->width(Con::TILE)/2);
        $y = rand(0, $region->height(Con::TILE)/2);

        $config = [
            'tile_size' => (int) $region->tileSize() / 2,
            'origin_x' => (int) $grid->getX($x),
            'origin_y' => (int) $grid->getY($y),
            'ground_color' => (new Color())->grey(100),
            'tiles_wide' => $region->width(Con::TILE),
            'tiles_high' => $region->height(Con::TILE),
            'canvas' => $region->canvas()
        ];

//        $subRegion = $region->newSubRegion(10,10,10,10);
        $subRegion = (new Region($config))
            ->_setColor('dark', ['grey' => 80]);
        osd($subRegion);
        $subGrid = new Grid($subRegion, ['grid_color' => (new Color())->setColor(0, 127, 127)]);

        $subRegion->image();
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
            $xi = rand(1, $grid->region()->width(Con::TILE));
            $yi = rand(1, $grid->region()->height(Con::TILE));
            /* @var Tile $t */
            $t = $pool->tile($xi, $yi);

            $r->fill($this->_canvas, $t);
        }
    }

}
