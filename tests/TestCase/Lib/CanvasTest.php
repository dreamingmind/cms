<?php

namespace App\Test\TestCase\Lib;

use App\Constants\Con;
use App\GDPrimitives\Color;
use App\Lib\Canvas;

class CanvasTest extends \Cake\TestSuite\TestCase
{

    /**
     * Class will not throw errors on config-less creation
     *
     * @return void
     */
    public function test_HasDefaultsForAllValues()
    {
        $canvas = new Canvas();
        $this->assertNotNull($canvas->tileSize());
        $this->assertEquals(0, $canvas->origin(Con::X));
        $this->assertEquals(0, $canvas->origin(Con::Y));
        $this->assertNotNull($canvas->height(Con::TILE));
        $this->assertNotNull($canvas->width(Con::TILE));
        $this->assertGreaterThan($canvas->width(Con::TILE), $canvas->width(Con::PIXEL));
        $this->assertGreaterThan($canvas->height(Con::TILE), $canvas->height(Con::PIXEL));
        $this->assertInstanceOf(Color::class, $canvas->_getColor('ground_color'));
    }

    /**
     * origin vals lock to zero, all other valid keys persist
     *
     * @return void
     */
    public function test_ConfigGathersProperValues()
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

        unset($config['origin_x'], $config['origin_y']);

        //Canvas origin is locked to 0,0
        $this->assertEquals(0, $canvas->origin(Con::X));
        $this->assertEquals(0, $canvas->origin(Con::Y));

        foreach ($config as $key => $value) {
            $this->assertEquals($value, $canvas->getConfig($key));
        }
    }

    /**
     * @return void
     */
    public function test_WidthYieldsProperValue()
    {
        $config = [
            'tiles_wide' => 10,
            'tile_size' => 10,
        ];
        $canvas = new Canvas($config);

        $this->assertEquals(10, $canvas->width(Con::TILE));
        /*
         * grids always draw on the first pixel of the next tile
         * so one is added to the width to show the last grid line
         */
        $this->assertEquals(101, $canvas->width(Con::PIXEL));
    }

    /**
     * @return void
     */
    public function test_HeightYieldsProperValue()
    {
        $config = [
            'tiles_high' => 10,
            'tile_size' => 10,
        ];
        $canvas = new Canvas($config);

        $this->assertEquals(10, $canvas->height(Con::TILE));
        /*
         * grids always draw on the first pixel of the next tile
         * so one is added to the width to show the last grid line
         */
        $this->assertEquals(101, $canvas->height(Con::PIXEL));
    }

    public function test_ColorRegistryIntegration()
    {
        $canvas = new Canvas();
        $colors = $canvas->_getColor('current')->getColorValue();
        $canvas->setColor('ground_color', [7,7,7]);
        $newColors = $canvas->_getColor('current')->getColorValue();

        $this->assertNotEquals($colors, $newColors);
        $this->assertEquals(
            ['r' => 7, 'g' => 7, 'b' => 7],
            $newColors
        );
        //local setter is chainable
        $this->assertInstanceOf(
            Canvas::class,
            $canvas->setColor('gr', ['grey' => 50])
        );

    }

    public function test_imageRenders()
    {
        $canvas = new Canvas();
        $this->assertNotFalse($canvas->image());
        $this->assertTrue(is_resource($canvas->image()));
    }

}
