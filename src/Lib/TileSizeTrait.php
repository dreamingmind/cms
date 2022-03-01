<?php

namespace App\Lib;

use App\Constants\Con;

trait TileSizeTrait
{
    /**
     * @param string $unit
     * @param string $axis
     * @return float|int|mixed
     */
    protected function size(string $unit, string $axis)
    {
        return $unit === Con::TILE
            ? $axis
            : ($axis * $this->getConfig('tile_size')) + 1;
    }


}