<?php

namespace App\GDPrimitives;

use App\Lib\ColorRegistry;
use App\Lib\ColorRegistryTrait;

class Rectangle
{

    use ColorRegistryTrait;

    /**
     * @var Color[]
     */
    private $color = [];

    public function __construct()
    {
        $this->color['stroke'] = ColorRegistry::get('stroke');
        $this->color['fill'] = ColorRegistry::get('fill');
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

    /**
     * @param string $type 'stroke' or 'fill'
     * @return Color|array
     */
    public function getColor($type)
    {
        if (in_array($type, ['stroke', 'fill'])) {
            return $this->color[$type];
        }
        return $this->_getColor($type);
    }

    /**
     * @param string $type 'fill' or 'stroke'
     * @param string|Color $key
     * @param $specs ['grey' => %] or [r-val, g-val, b-val]
     * @return void
     */
    public function setColor($type, $key, $specs = [])
    {
        if ($key instanceof Color) {
            $this->color[$type] = $key;
        }
        else {
            $this->color[$type] = ColorRegistry::set($key, $specs);
        }
        return $this->color[$type];
    }

}
