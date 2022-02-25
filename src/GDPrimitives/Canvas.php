<?php

namespace App\GDPrimitives;

use Migrations\ConfigurationTrait;

class Canvas
{

    protected $defaultConfig = [
        'tiles_wide' => 50,
        'tiles_high' => 25,
        'tile' => 70,
    ];

    public function __construct($config)
    {
        $region = new Region($config);
        $grid = new Grid($region);
        $grid->color()->setColor(255, 0,0);

        $this->_canvas = $region->out();
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
        $config = [
            'tile_size' => (int) $region->tileSize() / 2,
            'origin_x' => (int) $grid->getX(2),
            'origin_y' => (int) $grid->getY(3),
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
