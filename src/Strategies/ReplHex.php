<?php

namespace App\Strategies;

use App\Constants\Con;
use App\GDPrimitives\Color;
use App\GDPrimitives\HexGrid;
use App\GDPrimitives\Rectangle;
use App\Lib\Region;

class ReplHex
{

    /**
     * @param int[] $array
     */
    public function __construct(array $config = [])
    {
        $region = (new Region($config))
            ->setColor('fill', 'light', ['grey' => 15])
            ->setColor('stroke', 'redish', [199, 66, 22]);

        $this->_canvas = $region->draw();

        $this->subRegion($region);


    }

    public function output()
    {
        header('Content-Type: image/png');
        imagejpeg($this->_canvas, WWW_ROOT.'img/dungeon.png');
        imagedestroy($this->_canvas);
    }

    private function subRegion(Region $region)
    {
        $x = rand(0, $region->width(Con::TILE) / 2);
        $y = rand(0, $region->height(Con::TILE) / 2);

        $config = [
            'tile_size' => (int)$region->tileSize(),
            'origin_x' => (int)$region->grid()->getX($x),
            'origin_y' => (int)$region->grid()->getY($y),
            'ground_color' => (new Color())->grey(100),
            'tiles_wide' => $region->width(Con::TILE) / 2,
            'tiles_high' => $region->height(Con::TILE) / 2,
            'grid' => HexGrid::class,
        ];

        $subRegion = $region->newSubRegion($config)
//            ->setColor('fill', 'ground')
            ->setColor('fill', 'light', ['grey' => 15])
            ->setColor('stroke', 'black', ['grey' => 100]);
        $subRegion->grid()->stroke = 1;

        $subRegion->draw();
    }


}
