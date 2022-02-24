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

        $this->config = array_merge($this->defaultConfig, $config);

        $this->_canvas = $region->out();
        $this->renderGrid($region, $grid);

        $this->subRegion($region);
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

    private function subRegion(Region $region)
    {
        $config = [
            'tile_size' => (int) $region->tileSize() / 2,
            'origin_x' => (int) $region->x(25),
            'origin_y' => (int) $region->y(25),
            'ground_color' => (new Color())->grey(100),
            'tiles_wide' => $region->tilesWide(),
            'tiles_high' => $region->tilesHigh(),
        ];
        $subRegion = new Region($config);
        $subGrid = new Grid($subRegion, ['grid_color' => (new Color())->setColor(0, 127, 127)]);
        $subRegion->add($this->_canvas);
        $this->renderGrid($subRegion, $subGrid);

    }

    /**
     * @param Region $region
     * @param Grid $grid
     * @return void
     */
    private function renderGrid(Region $region, Grid $grid): void
    {
        foreach (range(0, $region->tilesWide()) as $i => $x) {
            $xLine[] = $grid->xLine($i);
            $xLine[$i]->add($this->_canvas);
        }
        foreach (range(0, $region->tilesHigh()) as $i => $y) {
            $yLine[] = $grid->yLine($i);
            $yLine[$i]->add($this->_canvas);
        }
    }

}
