<?php

namespace App\GDPrimitives;

class Grid
{

    /**
     * @var Point
     */
    private $pt1;
    /**
     * @var Point
     */
    private $pt2;
    /**
     * @var int|mixed
     */
    private $tile;


    public function __construct(Point $pt1, Point $pt2, $tile = 70)
    {
        $this->pt1 = $pt1;
        $this->pt2 = $pt2;
        $this->tile = $tile;
    }

    public function xLine($x)
    {
        $p1 = new Point($this->tile * $x + $this->pt1->x(), $this->pt1->y());
        $p2 = new Point($this->tile * $x + $this->pt1->x(), $this->pt2->y());
        return new PointPair($p1, $p2);
    }
}
