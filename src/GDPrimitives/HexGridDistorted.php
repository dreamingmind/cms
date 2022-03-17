<?php

namespace App\GDPrimitives;

use App\Constants\Con;
use App\Lib\Region;
use App\Registries\ColorRegistry;
use App\Traits\ConfigTrait;

class HexGridDistorted extends Grid
{

    /**
     * @inheritDoc
     */
    public function draw($canvas): void
    {
        parent::draw($canvas);
    }

    public function getTiles()
    {
        return parent::getTiles();
    }

}