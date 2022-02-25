<?php

namespace App\GDPrimitives;

class FlyweightRectangle
{

    /**
     * @param $canvas
     * @param Point[] $points
     * @param $width
     * @return void
     */
    public function stroke($canvas, array $points, $width)
    {

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
        $c = (new Color())->grey(100);

        imagerectangle(
            $canvas,
            $p1->x() + $count,
            $p1->y() + $count,
            $p2->x() - $count,
            $p2->y() - $count,
//            (new Color())->setColor(90,200, 55)->allocate($this->_canvas)
            $c->allocate($canvas)
        );

    }
}
