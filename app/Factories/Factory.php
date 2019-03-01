<?php

namespace App\Factories
{
    class Factory
    {
        static public function factory(string $type, \stdClass $raw) : object
        {
            $obj = new $type();
            $properties = get_class_vars($type);

            foreach($properties as $name => $value)
            {
                if(property_exists($raw, $name))
                    $obj->$name = $raw->$name;
            }

            return $obj;
        }
    }
}