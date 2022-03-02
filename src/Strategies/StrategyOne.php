<?php

namespace App\Strategies;

use App\Constants\Con;
use App\GDPrimitives\Color;
use App\GDPrimitives\Grid;
use App\GDPrimitives\Rectangle;
use App\GDPrimitives\Tile;
use App\Traits\ColorRegistryTrait;
use App\Lib\Region;
use App\Lib\Room;

class StrategyOne
{

    use ColorRegistryTrait;

    protected $defaultConfig = [
        'tiles_wide' => 50,
        'tiles_high' => 25,
        'tile' => 70,
    ];

    public function __construct($config = [])
    {

        $t = osdTime();
        $t->start();
        $region = new Region($config);
        $grid = (new Grid($region))
            ->_setColor('redish', [199, 66, 22]);

        $this->_canvas = $region->image();
        $grid->add($region->image());

        $this->randomBlocks(
            $grid,
            new Rectangle()
        );

        foreach (range(0,5) as $count) {
            $room = new Room($grid->region());
            $room->add($region->image(), $grid->getTiles());
        }

        $this->subRegion($region, $grid);
        $t->end();
//        osd($t->result());
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
        ];

        $subRegion = $region->newSubRegion($config)
            ->_setColor('dark', ['grey' => 80]);

        $subGrid = new Grid(
            $subRegion,
            ['grid_color' => (new Color())->setColor(0, 127, 127)]
        );
        $subRegion->add($region->image());
        $subGrid->add($region->image());

        $this->randomBlocks($subGrid, new Rectangle());

    }

    /**
     * @param Grid $grid
     * @param Rectangle $r
     * @return void
     */
    private function randomBlocks(Grid $grid, Rectangle $r): void
    {
        $pool = $grid->getTiles();
        $max = count($pool->tiles()) * .1;
        foreach (range(1, $max) as $c) {
            $xi = rand(1, $grid->region()->width(Con::TILE));
            $yi = rand(1, $grid->region()->height(Con::TILE));
            /* @var Tile $t */
            $t = $pool->tile($xi, $yi);

            $r->fill($this->_canvas, $t);
        }
    }

}
