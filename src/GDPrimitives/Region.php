<?php

namespace App\GDPrimitives;

use App\Lib\ConfigTrait;
use Cake\Utility\Hash;

class Region
{

    use ConfigTrait;

    protected $defaultConfig = [
        'origin_x' => 0,
        'origin_y' => 0,
        'tiles_wide' => 50,
        'tiles_high' => 25,
        'tile_size' => 70,
        'ground_color' => null,
    ];
    /**
     * @var array
     */
    public $config = [];

    public function __construct($config = [])
    {
        $this->config = array_merge($this->defaultConfig, $config);
        $this->setConfig(
            'ground_color',
            $this->getConfig(
                'ground_color',
                (new Color())->setColor(193,179,131)
            )
        );
    }

}
