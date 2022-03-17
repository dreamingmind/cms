<?php

namespace App\Test\TestCase\Lib;

use App\GDPrimitives\Grid;
use App\GDPrimitives\PointPair;
use App\Lib\Canvas;
use App\Lib\Region;
use App\Lib\SubRegion;
use App\Registries\ColorRegistry;
use App\Traits\ColorRegistryTrait;
use Cake\Event\EventManager;
use Cake\Test\TestCase;

class RegionCreationTasksTest extends \Cake\TestSuite\TestCase
{

    protected function tearDown(): void
    {
        parent::tearDown();
        EventManager::instance()
            ->off('ColorRegistry.afterSetColor');

    }

    public function test_getPointPair()
    {
        $region = new Region();

        $this->assertInstanceOf(PointPair::class, $region->points());
    }

    public function test_GridWasConstructed()
    {
        $region = new Region();
        $grid = $region->grid();

        $this->assertInstanceOf(Grid::class, $grid);
        $this->assertEquals(
            $region->getColor('stroke'),
            $region->grid()->getColor(),
            'Grid color was not set by Region'
        );
    }

    public function test_CanvasWasConstructed()
    {
        $region = new Region();
        $canvas = $region->canvas();

        $this->assertInstanceOf(Canvas::class, $canvas);
        $this->assertEquals(
            $region->getColor('fill'),
            $region->canvas()->getColor(),
            'Canvas color was not set by the Region'
        );
    }

    public function test_ColorTraitIsInUse()
    {
        $region = new Region();

        $this->assertArrayHasKey(ColorRegistryTrait::class, class_uses($region));
        $this->assertTrue(property_exists($region, 'color'));
    }

    public function test_ColorsWhereInitialized()
    {
        $region = new Region();

        $this->assertEquals(
            ColorRegistry::get('ground'),
            $region->getColor('fill')
        );
        $this->assertEquals(
            ColorRegistry::get('grid'),
            $region->getColor('stroke')
        );

    }

    public function test_CreateSubRegion()
    {
        $region = new Region();
        $subRegion = $region->newSubRegion();

        $this->assertInstanceOf(SubRegion::class, $subRegion);
    }
}
