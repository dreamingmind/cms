<?php

namespace App\Test\TestCase\Traits;

use App\Exceptions\MissingClassPropertyException;
use App\GDPrimitives\Color;
use App\Lib\ColorRegistry;
use App\Traits\ColorRegistryTrait;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\TestSuite\TestCase;

class ColorRegistryTraitTest extends TestCase
{

    /**
     * Clear the Static Registry Class each time
     */
    public function setUp() : void
    {
        ColorRegistry::reset();
        $m = EventManager::instance();
        debug($m->matchingListeners('.'));
        EventManager::instance()
            ->off('ColorRegistry.afterSetColor');
    }

    //<editor-fold desc="Tests for Registry::_getColor() functionality (inspect registry content)">

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

    //<editor-fold desc="Tests for local::getColor() functionality (inspect class property)">
    public function test_getColorWhenNoneDefined()
    {
        $class = new UserOfColorTrait();

        $this->assertEmpty($class->getColor());
        $this->assertNull($class->getColor('fill'));
    }
    //</editor-fold> (

    //<editor-fold desc="Tests for Registry::_setColor functionality (set registry content)">
    public function test__setColorMakesNewRegistryEntry()
    {
        $class = new UserOfColorTrait();
        $color = $class->_setColor('rando', ['grey' => 100]);

        $this->assertInstanceOf(Color::class, $color);
        $this->assertCount(1, $class->_getColor());
    }

    public function test__setColorLeavesLocalPropertyUntouched()
    {
        $class = new UserOfColorTrait();
        $this->makeBlackAndWhite($class);

        $this->assertEmpty($class->getColor());
    }
    //</editor-fold>

    //<editor-fold desc="Tests for local::setColor functionality (set local class property)">
    public function test_setColorIsChainable()
    {
//        debug(EventManager::instance()/*->off('ColorRegistry.afterSetColor')*/);die;
        $class = (new UserOfColorTrait())
            ->setColor('fill', 'black', [0,0,0])
            ->setColor('stroke', 'black', [0,0,0]);

        $this->assertInstanceOf(UserOfColorTrait::class, $class);
    }

    public function test_setColorAcceptsColorObject()
    {
        $class = new UserOfColorTrait();
        $color = new Color('test', [255,255,255]);
        $class->setColor('fill', $color);

        $this->assertEquals($color, $class->getColor('fill'));
        $this->assertEquals($color, $class->_getColor('test'));
    }

    public function test_setColorMakesDefaultWhenSpecsMissing()
    {
        $class = new UserOfColorTrait();
        $class->setColor('stroke', 'test');
        $color = $class->getColor('stroke');

        $this->assertInstanceOf(Color::class, $color);
        $this->assertEquals('test', $color->alias());
        $this->assertInstanceOf(Color::class, $class->_getColor('test'));
    }

    public function test_setColorFromARegisteredColor()
    {
        $class = new UserOfColorTrait();
        $this->makeBlackAndWhite($class);
        $class
            ->setColor('fill', 'white')
            ->setColor('stroke', 'black');

        $this->assertCount(2, $class->_getColor());
        $this->assertCount(2, $class->getColor());
    }

    public function test_setColorFromSpecsIsStored()
    {
        $class = (new UserOfColorTrait())
            ->setColor('fill', 'green', [0,255,0])
            ->setColor('stroke', 'fifty', ['grey' => 50]);

        $this->assertEquals('green', $class->getColor('fill')->alias());
        $this->assertEquals('fifty', $class->getColor('stroke')->alias());
    }
    //</editor-fold>

    //<editor-fold desc="Utilities to generate colors">
    private function makeBlackAndWhite(UserOfColorTrait $class)
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
    //</editor-fold>
}

class UserOfColorTrait
{
    use ColorRegistryTrait;
}
