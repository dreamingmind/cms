<?php

namespace App\Lib;

use App\GDPrimitives\Color;

/**
 * @property Color $color
 */
trait ColorRegistryTrait
{

    public function _getColor(string $key = null)
    {
        if ($key === 'current') {
            return $this->color;
        }
        return ColorRegistry::get($key);
    }

    public function _setColor(string $key, array $spec) {
        $this->color = ColorRegistry::set($key, $spec);
        return $this->color;
    }
}
