<?php

namespace App\GDPrimitives;

use App\Lib\PointPairInterface;

class Tile implements PointPairInterface
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
     * @param string|null $part
     * @return mixed
     */
    public function getId(string $part = null)
    {
        if(is_null($part)) {
            return $this->index['i'];
        }
        return $this->index[$part];
    }


    public function points(): PointPair
    {
        return $this->pts;
    }

    public function stroke($canvas, $width, $color = null)
    {
        $r = new Rectangle();
        $r->stroke(
            $canvas,
            [
                $this->pts->getPoint(0,0),
                $this->pts->getPoint(100, 100)
            ],
            $width
        );
    }

}
