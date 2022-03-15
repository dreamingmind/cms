<?php

namespace App\GDPrimitives;

use App\Lib\ColorRegistry;
use App\Traits\ColorRegistryTrait;
use App\Interfaces\PointPairInterface;

class Rectangle
{

    use ColorRegistryTrait;


    public function __construct()
    {
        $this->setColor('stroke', 'stroke');
        $this->setColor('fill', 'stroke');
    }

    /**
     * @param $canvas
     * @param Point|PointPairInterface $p1
     * @param $p2
     * @return void
     */
    public function fill($canvas, $p1, $p2 = null)
    {
        if (is_object($p1) && class_implements($p1, PointPairInterface::class)){
            list($p1, $p2) = $p1->points()->pair();
        }
        imagefilledrectangle(
            $canvas,
            $p1->x(),
            $p1->y(),
            $p2->x(),
            $p2->y(),
            $this->getColor('fill')->allocate($canvas));
    }

    /**
     * @param $canvas
     * @param Point[] $points
     * @param $width
     * @param Color|null $color
     * @return void
     */
    public function stroke($canvas, array $points, $width)
    {
        $color = $color ?? $this->getColor('stroke');

        foreach (range(0, $width - 1) as $count) {
            $this->perimeter($canvas, $points, $count);
        }
    }

    private function perimeter($canvas, $points, $count)
    {
        /* @var Point $p1 */
        /* @var Point $p2 */
        $p1 = $points[0];
        $p2 = $points[1];

        imagerectangle(
            $canvas,
            $p1->x() + $count,
            $p1->y() + $count,
            $p2->x() - $count,
            $p2->y() - $count,
            $this->getColor('stroke')->allocate($canvas)
        );
    }

}
