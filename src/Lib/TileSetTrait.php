<?php

namespace App\Lib;

use App\GDPrimitives\Tile;

trait TileSetTrait
{

    public function tile(int $xi, int $yi): Tile
    {
        return $this->tiles[$this->key($xi, $yi)];
    }

    public function key(int $xi, int $yi): string
    {
        return "$xi-$yi";
    }

}
