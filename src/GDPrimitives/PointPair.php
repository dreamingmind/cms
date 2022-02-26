<?php

namespace App\GDPrimitives;

use App\Lib\AuthenticationTrait;

class PointPair
{

    use AuthenticationTrait;

    /**
     * @var int[]
     */
    private $x = [];
    /**
     * @var int[]
     */
    private $y = [];

    /**
     * Insure 'normal' data arrangement
     * <pre>
     * 1------
     * |     |
     * ------2
     * also view as
     * lo-----
     * |     |
     * -----hi
     * </pre>
     * @param Point $p1
     * @param Point $p2
     */
    public function __construct(Point $p1, Point $p2)
    {
        $x1 = $p1->x();
        $x2 = $p2->x();
        if ($x1 <= $x2) {
            $this->x['lo'] = $x1;
            $this->x['hi'] = $x2;
        }
        else {
            $this->x['hi'] = $x1;
            $this->x['lo'] = $x2;
        }
        $y1 = $p1->y();
        $y2 = $p2->y();
        if ($y1 <= $y2) {
            $this->y['lo'] = $y1;
            $this->y['hi'] = $y2;
        }
        else {
            $this->y['hi'] = $y1;
            $this->y['lo'] = $y2;
        }

    }

    /**
     * @param $i 'lo', 'hi', int representing a % between lo & hi
     * @return int
     */
    public function getX($i): int
    {
        if(is_numeric($i)) {
            return $this->percent($this->getX('lo'), $this->getX('hi'), $i);
        }
        return $this->x[$i];
    }

    /**
     * @param $i 'lo', 'hi', int representing a % between lo & hi
     * @return int
     */
    public function getY($i): int
    {
        if(is_numeric($i)) {
            return $this->percent($this->getY('lo'), $this->getY('hi'), $i);
        }
        return $this->y[$i];
    }

    public function getPoint($xPC, $yPC): Point
    {
        return new Point($this->getX($xPC), $this->getY($yPC));
    }

    private function percent(int $lo, int $hi, int $pc): int
    {
        return (int) (($hi - $lo) * ($pc / 100)) + $lo;
    }

}
