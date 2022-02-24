<?php

namespace App\GDPrimitives;


class Line
{

    public function __construct(Point $pt1, Point $pt2, Color $color)
    {
        $this->pt1 = $pt1;
        $this->pt2 = $pt2;
        $this->color = $color;
    }

    public function add($canvas)
    {
        imageline(
            $canvas,
            $this->pt1->x(),
            $this->pt1->y(),
            $this->pt2->x(),
            $this->pt2->y(),
            $this->color->allocate($canvas)
        );

    }

}
