<?php

namespace App\Test\TestCase\Lib;

use App\Constants\Con;
use App\GDPrimitives\Color;
use App\Lib\Canvas;
use App\Lib\Region;

class RegionTest extends \Cake\TestSuite\TestCase
{

    public function test_configUsedToMakeCanvas()
    {
        $config = [
            'origin_x' => 10,
            'origin_y' => 10,
            'tiles_wide' => 10,
            'tiles_high' => 10,
            'tile_size' => 10,
            'ground_color' => new Color('test'),
        ];

        $canvas = new Canvas($config);
        $region = new Region($config);
        $this->assertTrue($canvas == $region->canvas());
    }

    public function test_RegionMethodsDelgateToCanvas()
    {
        /**
         * tileSize
         * origin
         * width
         * height
         * image
         */
        $canvas = $this->createMock(Canvas::class);
        $canvas->expects($this->once())
            ->method('tileSize');
        $canvas->expects($this->once())
            ->method('origin');
        $canvas->expects($this->once())
            ->method('width');
        $canvas->expects($this->once())
            ->method('height');
        $canvas->expects($this->once())
            ->method('image');

        $region = new Region(['canvas' => $canvas]);
        $region->tileSize();
        $region->origin(Con::X);
        $region->width(Con::TILE);
        $region->height(Con::PIXEL);
        $region->image();
        debug($region->canvas());
    }
}
