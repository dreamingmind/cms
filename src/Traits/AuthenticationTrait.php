<?php

namespace App\Traits;

use phpDocumentor\Reflection\Types\Iterable_;

trait AuthenticationTrait
{

    /**
     * array contain only objects of a specific type?
     *
     * @param iterable $data
     * @return bool
     */
    private function isHomogenous(iterable $data, string $type)
    {
        return collection($data)
            ->reduce(function($accum, $element) use ($type) {
                return $accum && ($element instanceof $type);
            }, true);
    }

}
