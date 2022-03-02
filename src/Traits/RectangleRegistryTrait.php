<?php

namespace App\Traits;

use App\Registries\RectangleRegistry;

trait RectangleRegistryTrait
{

    public function _getRectangle(string $key = null)
    {
        if ($key === 'current') {
            return $this->rectangle;
        }
        return RectangleRegistry::get($key);
    }

    /**
     * @param string $key
     * @param array $spec  ['grey' => %] or [r, g, b] (see ColorRegistry::set())
     * @return $this
     */
    public function _setColor(string $key, $rectangle = null) {
        $this->rectangle = RectangleRegistry::set($key, $rectangle);
        return $this;
    }

}