<?php

namespace App\Lib;

interface RegionInterface
{

    public function tileSize(): int ;

    /**
     * @param string $axis Con::X or Con::Y
     * @return int
     */
    public function origin(string $axis) : int;

    /**
     * @param string $unit Con::TILE or Con::PIXEL
     * @return int
     */
    public function width(string $unit) : int;

    /**
     * @param string $unit Con::TILE or Con::PIXEL
     * @return int
     */
    public function height(string $unit) : int;

    public function image();

}
