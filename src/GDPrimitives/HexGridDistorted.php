<?php

namespace App\GDPrimitives;

use App\Constants\Con;
use App\Lib\Region;
use App\Registries\ColorRegistry;
use App\Traits\ConfigTrait;

class HexGridDistorted extends Grid
{

    /**
     * @inheritDoc
     */
    public function draw($canvas): void
    {
        imagesetthickness($canvas,1);

        collection(range(1, $this->region->width(Con::TILE)))
            ->map(function($x) {
                collection(range(1, $this->region->height(Con::TILE)))
                    ->map(function($y) use ($x) {
                        $this->drawHex($x, $y);
                    })
                    ->toArray();
            })
            ->toArray();
    }

    public function getTiles()
    {
        return parent::getTiles();
    }

    private function drawHex($x, $y)
    {
        $shift = $x % 2 ? .5 * $this->region()->tileSize() : 0;

        $origin = new PointPair(
            new Point(
                $this->getX($x - 1),
                $this->getY($y - 1) + $shift
            ),
            new Point(
                $this->getX($x),
                $this->getY($y) + $shift
            )

        );

        $vertices = [
            $origin->getPoint(-12.5, 50),
            $origin->getPoint(12.5, 100),
            $origin->getPoint(87.5, 100),
            $origin->getPoint(112.5, 50),
            $origin->getPoint(87.5, 0),
            $origin->getPoint(12.5, 0),
        ];


        $values = collection($vertices)
            ->reduce(function($accum,$point){
                /* @var Point $point */
                $accum[] = $point->x();
                $accum[] = $point->y();
                return $accum;
            },[]);

        imagepolygon(
            $this->region()->image(),
            $values,
            count($values)/2,
            $this->getColor()->allocate($this->region()->image())
        );

    }

}