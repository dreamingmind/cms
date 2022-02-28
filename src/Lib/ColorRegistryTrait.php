<?php

namespace App\Lib;

use App\GDPrimitives\Color;

/**
 * @property Color $color
 */
trait ColorRegistryTrait
{

    /**
     * Get a Color object or some set of them
     *
     * $key = null : all Colors in the registry (array)
     * $key = 'current' : the Color or array of Colors in the current object
     * $key = string : a specific Color from the registry (will provide default)
     *
     * @param string|null $key
     * @return Color|Color[]
     */
    public function _getColor(string $key = null)
    {
        if ($key === 'current') {
            return $this->color;
        }
        return ColorRegistry::get($key);
    }

    /**
     * @param string $key
     * @param array $spec  ['grey' => %] or [r, g, b] (see ColorRegistry::set())
     * @return $this
     */
    public function _setColor(string $key, array $spec) {
        $this->color = ColorRegistry::set($key, $spec);
        return $this;
    }
}
