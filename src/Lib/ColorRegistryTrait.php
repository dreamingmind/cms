<?php

namespace App\Lib;

trait ColorRegistryTrait
{

    public function getColor(string $key = null)
    {
        return ColorRegistry::get($key);
    }

    public function setColor(string $key, array $spec) {
        return ColorRegistry::set($key, $spec);
    }
}
