<?php

namespace App\GDPrimitives;

use http\Exception\BadMethodCallException;

class Color
{
    protected $r = 255;
    protected $g = 255;
    protected $b = 255;
    protected $alias = '';

    public function __construct($alias = 'made manually')
    {
        $this->alias = $alias;
    }

    public function setColor($r, $g, $b): Color
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        return $this;
    }

    public function grey($percent): Color
    {
        $val = (int) (255 - (255 * ($percent / 100)));
        return $this->setColor($val, $val, $val);
    }

    public function allocate($image)
    {
        return imagecolorallocate($image, $this->r, $this->g, $this->b);
    }

    public function getColorValue($color = null)
    {
        if (is_null($color)) {
            return [
                'r' => $this->r,
                'g' => $this->g,
                'b' => $this->b,
            ];
        }
        if (in_array($color, ['r', 'g', 'b'])) {
            return $this->$color;
        }
        else {
            $msg = "'r', 'g', and 'b' or null are the only valid arguments";
            throw new BadConstructorValueException($msg);
        }
    }

}
