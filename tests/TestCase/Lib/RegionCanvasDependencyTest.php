<?php

namespace App\Test\TestCase\Lib;

use App\Constants\Con;
use App\GDPrimitives\Color;
use App\Lib\Canvas;
use App\Lib\Region;

class RegionCanvasDependencyTest extends \Cake\TestSuite\TestCase
{

    public function test_configUsedToMakeCanvas()
    {
        $config = [
            'tiles_wide' => 10,
            'tiles_high' => 10,
            'tile_size' => 10,
            'ground_color' => new Color('test'),
        ];

        $canvas = new Canvas($config);
        $region = new Region($config);
        $this->assertTrue($canvas == $region->canvas());
    }

    public function test_Image_DelgatesToCanvas()
    {
        $canvas = $this->createMock(Canvas::class);
        $canvas->expects($this->once())
            ->method('image');

        $region = new Region(['canvas' => $canvas]);
        $region->image();
    }

    public function test_Height_DelgatesToCanvas()
    {
        $canvas = $this->createMock(Canvas::class);
        $canvas->expects($this->atLeastOnce())
            ->method('height');

        $region = new Region(['canvas' => $canvas]);
        $region->height(Con::PIXEL);
    }

    public function test_Width_DelgatesToCanvas()
    {
        $canvas = $this->createMock(Canvas::class);
        $canvas->expects($this->atLeastOnce())
            ->method('width');

        $region = new Region(['canvas' => $canvas]);
        $region->width(Con::TILE);
    }

    public function test_Origin_DelgatesToCanvas()
    {
        $canvas = $this->createMock(Canvas::class);
        $canvas->expects($this->atLeastOnce())
            ->method('origin');

        $region = new Region(['canvas' => $canvas]);
        $region->origin(Con::X);
    }

    public function test_Tile_SizeDelgatesToCanvas()
    {
        $canvas = $this->createMock(Canvas::class);
        $canvas->expects($this->once())
            ->method('tileSize');

        $region = new Region(['canvas' => $canvas]);
        $region->tileSize();
    }

}
