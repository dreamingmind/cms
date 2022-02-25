<?php

namespace App\GDPrimitives;

class Tile
{

    public function __construct($xIndex, $yIndex, Grid $grid)
    {
        $this->index = "$xIndex-$yIndex";
        $this->xLo = $grid->getX($xIndex - 1) +1;
        $this->xHi = $grid->getX($xIndex) - 1;
        $this->yLo = $grid->getY($yIndex - 1) +1;
        $this->yHi = $grid->getY($yIndex) - 1;
    }

    public function xLo()
    {
        return $this->xLo;
    }
    public function xHi()
    {
        return $this->xHi;
    }
    public function yLo()
    {
        return $this->yLo;
    }
    public function yHi()
    {
        return $this->yHi;
    }
}
