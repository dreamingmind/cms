<?php

namespace App\Lib;

use App\GDPrimitives\Color;
use Cake\Core\ObjectRegistry;
use Cake\Utility\Hash;

class ColorRegistry
{
    protected static $keys = [
        'ground' => [193,179,131],
        'grid' => ['grey' => 50],
        'tile_fill' => ['grey' => 15],
        'tile_stroke' => ['grey' => 50],
        'fill' => ['grey' => 15],
        'stroke' => ['grey' => 50],
        'default' => ['255', 0, 0]
    ];

    protected static $colors = [];

    public static function get($key = null)
    {
        if (is_null($key)) {
            return self::$colors;
        }
        if (!key_exists($key, self::$colors)) {
            self::initialize($key);
        }
        return self::$colors[$key];
    }

    /**
     * @param string $key
     * @param array $color ['grey' => %] or [r-val, g-val, b-val]
     * @return Color|void
     */
    public static function set($key, $color = [])
    {
        return self::make($key, $color);
    }

    private static function initialize($key)
    {
        $spec_key = key_exists($key, self::$keys) ? $key : 'default';
        $spec = self::$keys[$spec_key];
        self::make($key, $spec);
    }

    /**
     * @param $spec
     * @param $key
     * @return void
     */
    private static function make($key, $spec): Color
    {
        $color = new Color($key);
        if (key_exists('grey', $spec)) {
            $color->grey($spec['grey']);
        }
        else {
            list($r, $g, $b) = array_values($spec);
            $color->setColor($r, $g, $b);
        }
        self::$colors[$key] = $color;
        return $color;
    }

}
