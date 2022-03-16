<?php

namespace App\Strategies;

use App\Constants\Con;
use App\GDPrimitives\Color;
use App\GDPrimitives\Grid;
use App\GDPrimitives\Rectangle;
use App\GDPrimitives\Tile;
use App\Lib\ColorRegistry;
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
        $region = (new Region($config))
            ->setColor('fill', 'fp', ['grey' => 20])
            ->setColor('stroke', 'redish', [199, 66, 22]);

        $this->_canvas = $region->draw();

        $this->randomBlocks(
            $region->grid(),
            new Rectangle()
        );

        foreach (range(0,5) as $count) {
            $room = new Room($region);
            $room->draw($region->image(), $region->grid()->getTiles());
        }

        $this->subRegion($region);
        $t->end();
    }

    public function output()
    {
        header('Content-Type: image/png');
        imagejpeg($this->_canvas, WWW_ROOT.'img/dungeon.png');
        imagedestroy($this->_canvas);
    }

    private function subRegion(Region $region)
    {
        $x = rand(0, $region->width(Con::TILE)/2);
        $y = rand(0, $region->height(Con::TILE)/2);

        $config = [
            'tile_size' => (int) $region->tileSize() / 2,
            'origin_x' => (int) $region->grid()->getX($x),
            'origin_y' => (int) $region->grid()->getY($y),
            'ground_color' => (new Color())->grey(100),
            'tiles_wide' => $region->width(Con::TILE),
            'tiles_high' => $region->height(Con::TILE),
        ];

        $subRegion = $region->newSubRegion($config)
            ->setColor('fill', 'dark', ['grey' => 80])
            ->setColor('stroke', 'white', ['grey' => 0]);

        $subRegion->draw();

        $this->randomBlocks($subRegion->grid(), new Rectangle());

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
