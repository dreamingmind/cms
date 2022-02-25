<?php

namespace App\GDPrimitives;

class PointSet
{

    /**
     * @param Point[] $Pts
     */
    public function __construct(array $Pts)
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
