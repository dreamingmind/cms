<?php

namespace App\Interfaces;

use App\Constants\Con;
use App\GDPrimitives\Color;
use App\GDPrimitives\Grid;
use App\GDPrimitives\Line;
use App\GDPrimitives\Point;
use App\Lib\Region;
use App\Lib\TilePool;

interface GridInterface
{
    public function getX($n);

    /**
     * @param int $n grid increment
     * @return float|int
     */
    public function getY($n);

    /**
     * @param Region $region
     * @param Grid $grid
     * @return void
     */
    public function draw($canvas): void;

    public function getTiles();

    public function region();

    public function setColor(Color $stroke_color);

    public function getColor() : Color;

}
