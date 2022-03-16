<?php

namespace App\Test\TestCase\Lib;

use App\GDPrimitives\Grid;
use App\GDPrimitives\PointPair;
use App\Lib\Region;
use App\Lib\SubRegion;
use App\Traits\ColorRegistryTrait;
use Cake\Event\EventManager;
use Cake\Test\TestCase;

class RegionTest extends \Cake\TestSuite\TestCase
{

    protected function tearDown(): void
    {
        parent::tearDown();
        EventManager::instance()
            ->off('ColorRegistry.afterSetColor');

    }

    public function test_CreateSubRegion()
    {
        $region = new Region();
        $subRegion = $region->newSubRegion();

        $this->assertInstanceOf(SubRegion::class, $subRegion);
    }

    public function test_getPointPair()
    {
        $region = new Region();

        $this->assertInstanceOf(PointPair::class, $region->points());
    }

    public function test_GridWasConstructed()
    {
        $grid = (new Region())->grid();

        $this->assertInstanceOf(Grid::class, $grid);
    }

    public function test_ColorTraitIsInUse()
    {
        $region = new Region();

        $this->assertArrayHasKey(ColorRegistryTrait::class, class_uses($region));
        $this->assertTrue(property_exists($region, 'color'));
    }

}
