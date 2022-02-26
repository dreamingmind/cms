<?php

namespace App\GDPrimitives;

class Tile
{

    /**
     * @var array
     */
    private $index;
    /**
     * @var PointPair
     */
    private $pts;

    public function __construct($xIndex, $yIndex, Grid $grid)
    {
        $this->index = [
            'x' => $xIndex,
            'y' => $yIndex,
            'i' => "$xIndex-$yIndex"
        ];
        $this->pts = new PointPair(
            new Point($grid->getX($xIndex) - 1, $grid->getY($yIndex) - 1),
            new Point($grid->getX($xIndex - 1) +1, $grid->getY($yIndex - 1) +1)
        );
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
        return $this->pts->getX($i);
    }

    /**
     * @param $i 'lo', 'hi', int representing a % between lo & hi
     * @return int
     */
    public function getY($i)
    {
        return $this->pts->getY($i);
    }

    public function getPoint($xPC, $yPC)
    {
        return $this->pts->getPoint($xPC, $yPC);
    }


    public function stroke($canvas, $width, $color = null)
    {
        $r = new Rectangle();
        $r->stroke(
            $canvas,
            [$this->pts->getPoint(0,0), $this->pts->getPoint(100, 100)],
            $width,
            $color
        );
    }

}
