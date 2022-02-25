<?php

namespace App\GDPrimitives;

use App\Lib\AuthenticationTrait;

class PointSet
{

    use AuthenticationTrait;

    /**
     * @param Point[] $Pts
     */
    public function __construct(iterable $Pts)
    {
        if (!$this->isHomogenous($Pts, Point::class)) {
            $msg = 'Only Points may be sent to the PointSet constructor';
            throw new BadConstructorValueException($msg);
        }

        $this->Pts = $Pts;
    }

    public function count()
    {
        return count($this->Pts);
    }

    public function getPts()
    {
        return $this->Pts;
    }
}
