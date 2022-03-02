<?php

namespace App\Registries;

use App\GDPrimitives\Rectangle;

class RectangleRegistry
{

    protected static $rectangles = [];

    public static function get(?string $key)
    {
        if (is_null($key)) {
            return self::$rectangles;
        }
        if (!key_exists($key, self::$rectangles)) {
            self::set($key, new Rectangle());
        }
        return self::$rectangles[$key];
    }

    public static function set(string $key, Rectangle $rectangle = null): ?Rectangle
    {
        self::$rectangles[$key] = $rectangle;
        return $rectangle;
    }
}