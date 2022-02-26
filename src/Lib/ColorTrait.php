<?php

namespace App\Lib;

trait ColorTrait
{

    public function getColor(string $key)
    {
        return ColorRegistry::get($key);
    }

    public function setColor(string $key, array $spec) {
        return ColorRegistry::set($key, $spec);
    }
}
