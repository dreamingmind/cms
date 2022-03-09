<?php

namespace App\Test\TestCase\Lib;

use App\GDPrimitives\Color;
use App\Lib\Region;
use App\Lib\SubRegion;

class RegionColorToolsTest extends \Cake\TestSuite\TestCase
{

    public function test_GetColorReadsCanvasColor()
    {
        $config = [
            'ground_color' => (new Color('test'))->setColor(0,0,0)
        ];
        $region = new Region($config);

        //read canvas directly
        $this->assertEquals(
            [0,0,0],
            array_values(
                $region->canvas()->_getColor('current')->getColorValue()
            )
        );

        //read through Region
        $this->assertEquals(
            [0,0,0],
            array_values(
                $region->getColor('current')->getColorValue()
            )
        );
    }

    public function test_SetColorSetsCanvasColor()
    {
        $config = [
            'ground_color' => (new Color('test', [0,0,0]))
        ];
        $region = new Region($config);
        $region->setColor('new', [127,127,127]);

        $this->assertEquals(
            [127,127,127],
            array_values(
                $region->getColor('current')->getColorValue()
            )
        );
    }

    public function test_SetColorIsChainable()
    {
        $region = new Region();
        $actual = $region->setColor('new', [127,127,127]);

        $this->assertInstanceOf(Region::class, $actual);
    }

}
