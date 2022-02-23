<?php

namespace App\GDPrimitives;


class Line
{

    public function __construct(Point $pt1, Point $pt2, $color, $canvas)
    {
        $this->pt1 = $pt1;
        $this->pt2 = $pt2;
        $this->color = $color;
        $this->canvas = $canvas;
    }

    public function add()
    {
        imageline(
            $this->canvas,
            $this->pt1->x(),
            $this->pt1->y(),
            $this->pt2->x(),
            $this->pt2->y(),
            $this->color
        );

    }

}
