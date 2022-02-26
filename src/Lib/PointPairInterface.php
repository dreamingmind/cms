<?php

namespace App\Lib;

use App\GDPrimitives\PointPair;

interface PointPairInterface
{

    /**
     * @return PointPair
     */
    public function points() : PointPair;
}
