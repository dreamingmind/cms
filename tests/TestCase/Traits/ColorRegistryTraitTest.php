<?php

namespace App\Test\TestCase\Traits;

use App\Traits\ColorRegistryTrait;

class ColorRegistryTraitTest extends \Cake\TestSuite\TestCase
{

    public function test__getColorReturnsFullRegistrySet()
    {
        $proxy = new UserOfColorTrait();
        debug($proxy->_getColor());
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