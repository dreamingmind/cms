<?php

namespace App\Interfaces;

use App\GDPrimitives\PointPair;

interface PointPairInterface
{

    /**
     * @return PointPair
     */
    public function points() : PointPair;
}
