<?php

namespace App\Test\TestCase\Traits;

use App\GDPrimitives\Color;
use App\Lib\ColorRegistry;
use App\Traits\ColorRegistryTrait;
use Cake\TestSuite\TestCase;

class ColorRegistryTraitTest extends TestCase
{

    /**
     * Clear the Static Registry Class each time
     */
    public function setUp() : void
    {
        ColorRegistry::reset();
    }

    //<editor-fold desc="Tests for Registry::_getColor() functionality">

    public function test__getColorReturnsFullRegistrySet()
    {
        $class = new UserOfColorTrait();

        $this->assertEmpty($class->_getColor());
        $this->makeBlackAndWhite($class);
        $this->assertCount(2, $class->_getColor());
    }

    public function test__getColorReturnsRequestedEntry()
    {
        $class = new UserOfColorTrait();
        $this->makeBlackAndWhite($class);
        $color = $class->_getColor('black');
        debug($color->getColorValue());

        $this->assertEquals('black', $color->alias());
        $this->assertEquals([0,0,0], array_values($color->getColorValue()));
    }

    public function test__getCreatesAndReturnsMissingEntry()
    {
        $class = new UserOfColorTrait();
        $color = $class->_getColor('rando');

        $this->assertInstanceOf(Color::class, $color);
        $registryEntries = $class->_getColor();
        $this->assertCount(1, $registryEntries);
        $this->assertArrayHasKey('rando', $registryEntries);
    }
    //</editor-fold>

    public function test_getColorWhenNoneDefined()
    {
        $class = new UserOfColorTrait();

        $this->assertEmpty($class->getColor());
        $this->assertNull($class->getColor('white'));
    }

    private function makeBlackAndWhite($class)
    {
        $class->_setColor('black', [0,0,0]);
        $class->_setColor('white', [255,255,255]);
    }

    private function makeWhiteFillColor($class)
    {
        $class->setColor('fill', 'white', [255,255,255]);
    }

    private function makeBlackStrokeColor($class)
    {
        $class->setColor('stroke', 'black', [0,0,0]);
    }
}

class BadUserOfColorTrait
{
    use ColorRegistryTrait;
    //missing required property
}

class UserOfColorTrait
{
    use ColorRegistryTrait;
    protected $color = [];
}