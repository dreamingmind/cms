<?php

namespace App\Strategies;

use App\Lib\Region;

class ReplHex
{

    /**
     * @param int[] $array
     */
    public function __construct(array $config = [])
    {
        $region = (new Region($config))
            ->setColor('fill', 'light', ['grey' => 15])
            ->setColor('stroke', 'redish', [199, 66, 22]);

        $this->_canvas = $region->draw();
    }

    public function output()
    {
        header('Content-Type: image/png');
        imagejpeg($this->_canvas, WWW_ROOT.'img/dungeon.png');
        imagedestroy($this->_canvas);
    }

}