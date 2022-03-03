<?php

namespace App\GDPrimitives;

use App\Interfaces\PointPairInterface;

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
     * @param string|null $part 'x', 'y', 'i', null (same as i)
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

    public function setUse($container) {

    }

}
