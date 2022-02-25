<?php

namespace App\GDPrimitives;

class Tile
{

    public function __construct($xIndex, $yIndex, Grid $grid)
    {
        $this->index = [
            'x' => $xIndex,
            'y' => $yIndex,
            'i' => "$xIndex-$yIndex"
        ];
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
     * Get the x|y grid index or the unique concatenated identifier
     *
     * @param null|string $part
     * @return int
     */
    public function getId($part = null)
    {
        if(is_null($part)) {
            return $this->index['i'];
        }
        return $this->index[$part];
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

    private function percent(int $lo, int $hi, int $pc): int
    {
        return (int) (($hi - $lo) * ($pc / 100)) + $lo;
    }

    public function stroke($canvas, $width)
    {
        $r = new FlyweightRectangle();
        $r->stroke(
            $canvas,
            [$this->getPoint(0,0), $this->getPoint(100, 100)],
            $width
        );
    }

}
