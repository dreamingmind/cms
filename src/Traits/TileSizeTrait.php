<?php

namespace App\Traits;

use App\Constants\Con;

trait TileSizeTrait
{
    /**
     * @param string $unit
     * @param string $axis
     * @return float|int|mixed
     */
    protected function size(string $unit, int $tileCount)
    {
        return $unit === Con::TILE
            ? $tileCount
            : ($tileCount * $this->getConfig('tile_size')) + 1;
    }


}
