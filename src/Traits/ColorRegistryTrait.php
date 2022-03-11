<?php

namespace App\Traits;

use App\Exceptions\MissingClassPropertyException;
use App\GDPrimitives\Color;
use App\Lib\ColorRegistry;

/**
 * @property Color $color
 */
trait ColorRegistryTrait
{

    /**
     * Get a Color object or some set of them from the ColorRegistry
     *
     * $key = null : all Colors in the registry (array)
     * $key = string : a specific Color from the registry (will provide default)
     *
     * @param string|null $alias
     * @return Color|Color[]
     */
    public function _getColor(string $alias = null)
    {
        if ($alias === 'current') {
            return $this->color;
        }
        return ColorRegistry::get($alias);
    }

    /**
     * Get one or all locally stored Color objects
     *
     * $key = null : all Colors in the $color property (array)
     * $key = string : a specific Color from the $color property
     *
     * @param string|null $type
     * @return Color|Color[]|null
     */
    public function getColor(string $type = null)
    {
        $this->verifyColorProperty();

        if (is_string($type)) {
            return $this->color[$type] ?? null;
        }
        return $this->color;
    }

    /**
     * Create a color registry entry and Color object on the fly
     *
     * @param string $alias
     * @param array $spec  ['grey' => %] or [r, g, b] (see ColorRegistry::set())
     * @return Color
     */
    public function _setColor(string $alias, array $spec): Color
    {
        ColorRegistry::set($alias, $spec);
        return $this->_getColor($alias);
    }

    /**
     * Set a local Color value for the class using this Trait
     *
     * Local remembered colors are typically 'fill' or 'stroke'
     * but you could implement something different if needed.
     *
     * If an $alias is provided with empty specs, the Color
     * stored in the registry under that alias will be used.
     * A default color will be created for that alias if
     * no color had previously been defined.
     *
     * If valid $specs are provided, the $alias entry will
     * be set to this color as will the local color $type
     *
     * @param string $type the name of the local color, typically 'fill' or 'stroke'
     * @param Color|string $alias Color or alias of registry entry
     * @param array $specs specs or empty for existing color (see set())
     * @return object the class using this trait (makes the chainable)
     * @throws MissingClassPropertyException
     */
    public function setColor(string $type, $alias, array $specs = []) : object
    {
        $this->verifyColorProperty();

        if ($alias instanceof Color) {
            $this->color[$type] = $alias;
        }
        elseif (empty($specs)) {
            $this->color[$type] = ColorRegistry::get($alias);
        }
        else {
            $this->color[$type] = ColorRegistry::set($alias, $specs);
        }
        return $this;
    }

    /**
     * @throws MissingClassPropertyException
     */
    private function verifyColorProperty(): void
    {
        if (!is_array($this->color ?? null)) {
            $msg = 'Users of ColorRegistryTrait must define the property $color = []';
            throw new MissingClassPropertyException($msg);
        }
    }
}
