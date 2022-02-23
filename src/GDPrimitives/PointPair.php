<?php

namespace App\GDPrimitives;

class PointPair
{

    /**
     * @param Point $p1
     * @param Point $p2
     */
    public function __construct(Point $p1, Point $p2)
    {
        $this->$p1 = $p1;
        $this->$p2 = $p2;
    }

    public function x($n)
    {
        $source = "p$n";
        return $this->$source->x();
    }

    public function y($n)
    {
        $source = "p$n";
        return $this->$source->y();
    }
}
