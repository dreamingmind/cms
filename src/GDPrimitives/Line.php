<?php

namespace App\GDPrimitives;


use App\Traits\ColorRegistryTrait;

class Line
{

    use ColorRegistryTrait;

    /**
     * @var PointPair
     */
    private $pts;


    /**
     * @param Point $pt1
     * @param Point $pt2
     * @param Color|null $color
     */
    public function __construct(Point $pt1, Point $pt2, Color $color = null)
    {
        $this->setColor('stroke', $color ?? 'stroke');
        $this->pts = new PointPair($pt1, $pt2);
    }

    public function draw($canvas)
    {
        imageline(
            $canvas,
            $this->points()->getX('lo'),
            $this->points()->getY('lo'),
            $this->points()->getX('hi'),
            $this->points()->getY('hi'),
            $this->getColor('stroke')->allocate($canvas)
        );
    }

    public function points()
    {
        return $this->pts;
    }

}
