<?php

namespace App\Lib;

use Cake\Utility\Hash;

trait ConfigTrait
{

    public function getConfig($path = null, $default = null)
    {

        return is_null($path)
            ? $this->config
            : Hash::get($this->config, $path, $default);
    }

    public function setConfig($path, $value)
    {
        $this->config = Hash::insert($this->config, $path,$value);
    }

}
