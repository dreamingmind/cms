<?php

namespace App\Registries;

use App\GDPrimitives\Color;

class ColorRegistry
{

    protected static $default_colors = [
        'ground' => [193,179,131],
        'grid' => ['grey' => 50],
        'tile_fill' => ['grey' => 15],
        'tile_stroke' => ['grey' => 50],
        'fill' => ['grey' => 15],
        'stroke' => ['grey' => 50],
        'default' => ['255', 0, 0]
    ];
    protected static $colors = [];

    public static function get($alias = null)
    {
        if (is_null($alias)) {
            return self::$colors;
        }
        if (!key_exists($alias, self::$colors)) {
            self::initialize($alias);
        }
        return self::$colors[$alias];
    }

    /**
     * @param string $alias
     * @param array $color ['grey' => %] or [r, g, b]
     * @return Color|void
     */
    public static function set($alias, $color = [])
    {
        return self::make($alias, $color);
    }

    public static function reset()
    {
        self::$colors = [];
    }

    private static function initialize($alias)
    {
        $spec_key = key_exists($alias, self::$default_colors) ? $alias : 'default';
        $spec = self::$default_colors[$spec_key];
        self::make($alias, $spec);
    }

    /**
     * @param $spec
     * @param $alias
     * @return void
     */
    private static function make($alias, $spec): Color
    {
        $color = new Color($alias);
        if (key_exists('grey', $spec)) {
            $color->grey($spec['grey']);
        }
        else {
            list($r, $g, $b) = array_values($spec);
            $color->setColor($r, $g, $b);
        }
        self::$colors[$alias] = $color;
        return $color;
    }

}
