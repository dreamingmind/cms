<?php

namespace App\GDPrimitives;

class FlyweightRectangle
{

    public function stroke($canvas, $tile, $width)
    {
        $this->$tile = $tile;
        foreach (range(0, $width - 1) as $count) {
            $this->perimeter($count);
        }
    }

    private function perimeter($count)
    {
        imagerectangle(
            $this->_canvas,
            $this->tile->xLo() + $count,
            $this->tile->yLo() + $count,
            $this->tile->xHi() - $count,
            $this->tile->yHi() - $count,
//            (new Color())->setColor(90,200, 55)->allocate($this->_canvas)
            (new Color())->grey(100)->allocate($this->_canvas)
        );

    }
}
