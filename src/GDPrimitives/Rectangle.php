<?php

namespace App\GDPrimitives;

class Rectangle
{

    /**
     * @var Color[]
     */
    private $color = [];

    public function __construct()
    {
        $this->color['stroke'] = (new Color())->grey(100);
        $this->color['fill'] = (new Color())->grey(0);
    }

    /**
     * @param $canvas
     * @param Point[] $points
     * @param $width
     * @param Color|null $color
     * @return void
     */
    public function stroke($canvas, array $points, $width, Color $color = null)
    {
        $color = $color ?? $this->getColor('stroke');

        foreach (range(0, $width - 1) as $count) {
            $this->perimeter($canvas, $points, $count, $color);
        }
    }

    private function perimeter($canvas, $points, $count, $color)
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
//            (new Color())->setColor(90,200, 55)->allocate($this->_canvas)
            $color->allocate($canvas)
        );
    }

    /**
     * @param string $type 'stoke' or 'color'
     * @return Color
     */
    public function getColor($type)
    {
        return $this->color[$type];
    }

}
