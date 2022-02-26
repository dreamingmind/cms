<?php

namespace App\GDPrimitives;


class Line
{

    /**
     * @var PointPair
     */
    private $pts;

    public function __construct(Point $pt1, Point $pt2, Color $color = null)
    {
        $this->color = $color;
        $this->pts = new PointPair($pt1, $pt2);
    }

    public function add($canvas)
    {
        imageline(
            $canvas,
            $this->points()->getX('lo'),
            $this->points()->getY('lo'),
            $this->points()->getX('hi'),
            $this->points()->getY('hi'),
            $this->color->allocate($canvas)
        );
    }

    public function points()
    {
        return $this->pts;
    }

}
