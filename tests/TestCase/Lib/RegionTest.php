<?php

namespace App\Test\TestCase\Lib;

use App\GDPrimitives\Grid;
use App\GDPrimitives\PointPair;
use App\Lib\Region;
use App\Lib\SubRegion;
use Cake\Test\TestCase;

class RegionTest extends \Cake\TestSuite\TestCase
{

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

}
