<?php

namespace App\Lib;

use App\Constants\Con;
use App\GDPrimitives\BadConstructorValueException;

class SubRegion extends Region
{

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->canvas = $this->getConfig('canvas', false);
        if (!$this->canvas || !($this->canvas instanceof Canvas)){
            $msg = 'Missing App\Lib\Canvas object in config[image]';
            throw new BadConstructorValueException($msg);
        }
        $this->config = array_merge($this->defaultConfig, $config);
        $this->color = $this->getConfig('ground_color', $this->_getColor('ground'));
    }

    public function add($canvas)
    {
        imagefilledrectangle(
            $canvas,
            $this->origin(Con::X),
            $this->origin(Con::Y),
            $this->origin(Con::X) + $this->width(Con::PIXEL),
            $this->origin(Con::Y) + $this->height(Con::PIXEL),
            $this->getConfig('ground_color')->allocate($canvas)
        );
    }


}
