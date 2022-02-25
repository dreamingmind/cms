<?php

namespace App\GDPrimitives;

use phpDocumentor\Reflection\PseudoTypes\NumericString;

class Tile
{

    public function __construct($xIndex, $yIndex, Grid $grid)
    {
        $this->index = "$xIndex-$yIndex";
        $this->xLo = $grid->getX($xIndex - 1) +1;
        $this->xHi = $grid->getX($xIndex) - 1;
        $this->yLo = $grid->getY($yIndex - 1) +1;
        $this->yHi = $grid->getY($yIndex) - 1;
        $this->x = [
            'hi' => $grid->getX($xIndex) - 1,
            'lo' => $grid->getX($xIndex - 1) +1
            ];
        $this->y = [
            'hi' => $grid->getY($yIndex) - 1,
            'lo' => $grid->getY($yIndex - 1) +1,
            ];
    }

    /**
     * @param $i 'lo', 'hi', int representing a % between lo & hi
     * @return int
     */
    public function getX($i)
    {
        if(is_numeric($i)) {
            return $this->percent($this->getX('lo'), $this->getX('hi'), $i);
        }
        return $this->x[$i];
    }

    /**
     * @param $i 'lo', 'hi', int representing a % between lo & hi
     * @return int
     */
    public function getY($i)
    {
        if(is_numeric($i)) {
            return $this->percent($this->getY('lo'), $this->getY('hi'), $i);
        }
        return $this->y[$i];
    }

    public function getPoint($xPC, $yPC)
    {
        return new Point($this->getX($xPC), $this->getY($yPC));
    }

    private function loHi($i)
    {
        return in_array($i, ['lo', 'hi']);
    }

    private function percent(int $lo, int $hi, int $pc)
    {
        return (int) (($hi - $lo) * ($pc / 100)) + $lo;
    }
}
