<?php

namespace DeveloperMode\Data;

use DeveloperMode\Data\Objects\DeveloperObject;
use pocketmine\utils\Config;

class Data
{

    /** @var array<string,array> */
    private $objects;

    public function __construct()
    {
        $this->objects = [];
    }

    public function hasData(string $name)
    {
        return isset($this->objects[$name]);
    }

    /**
     * @param string $name
     * @param DeveloperObject $object
     * @return void
     */
    public function setData(string $name, DeveloperObject $object)
    {
        $this->objects[$name] = $object->toArray();
    }

    /**
     * @param string $name
     * @return array
     */
    public function getData(string $name = null): array
    {
        if (is_null($name)) 
        {
            return $this->objects;
        }

        if ($this->hasData($name)) 
        {
            return $this->objects[$name];
        }

        return [];
    }
}
