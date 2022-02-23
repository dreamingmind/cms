<?php

namespace App\GDPrimitives;

use Migrations\ConfigurationTrait;

class Canvas
{

    protected $defaultConfig = [
        'width' => 50,
        'height' => 25,
        'tile' => 70,
    ];

    const TILES = 'tiles';
    const PIXELS = 'pixels';

    public function __construct($config)
    {
        $this->config = array_merge($this->defaultConfig, $config);
        $this->_canvas = imagecreatetruecolor(
            $this->width(self::PIXELS) + 1,
            $this->height(self::PIXELS) + 1
        );
        $gridColor = $this->color(80,80,80);
        foreach(range(0, $this->width() - 0) as $i => $x) {
            $xLine[] = new Line(
                new Point($this->config['tile'] * $x, 0),
                new Point($this->config['tile'] * $x, $this->height(self::PIXELS)),
                $this->grey(50),
                $this->_canvas
            );
            $xLine[$i]->add();
        }
        foreach(range(0, $this->height() - 0) as $i => $y) {
            $yLine[] = new Line(
                new Point(0, $this->config['tile'] * $y),
                new Point($this->width(self::PIXELS), $this->config['tile'] * $y),
                $this->grey(50),
                $this->_canvas
            );
            $yLine[$i]->add();
        }
    }

    public function get()
    {
        return $this->_canvas;
    }

    public function output()
    {
        header('Content-Type: image/png');
        imagejpeg($this->_canvas, WWW_ROOT.'img/dungeon.png');
        imagedestroy($this->_canvas);
    }

    private function width($scale = self::TILES)
    {
        return $scale === self::TILES
            ? $this->config['width']
            : $this->config['width'] * $this->config['tile'];
    }

    private function height($scale = self::TILES)
    {
        return $scale === self::TILES
            ? $this->config['height']
            : $this->config['height'] * $this->config['tile'];
    }

    private function color($r, $g, $b)
    {
        return imagecolorallocate($this->_canvas, $r, $g, $b);
    }

    public function grey($percent)
    {
        $val = (int) 256 * ($percent / 100);
        return imagecolorallocate($this->_canvas, $val, $val, $val);
    }
}
