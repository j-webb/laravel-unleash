<?php

namespace JWebb\Unleash\Entities;

abstract class AbstractEntity
{
    /**
     *
     * @param \stdClass|array|null $parameters
     * @throws \ReflectionException
     */
    public function __construct($parameters = null)
    {
        if (!$parameters) {
            return;
        }
        foreach ($parameters as $property => $value) {
            $property = static::convertToCamelCase($property);
            $this->setProperty($property, $value);
        }
    }

    /**
     * By default, simply set the property to the specified value
     *
     * When the value is an array of objects with a `type`
     * parameter, check if instantiation is possible.
     *
     * The value of `type` is used to decide which
     * class to attempt to instantiate
     *
     * @param $property
     * @param $value
     * @throws \ReflectionException
     */
    public function setProperty($property, $value)
    {
        if (!empty($value)) {
            // Get the class of the new entity we want to instantiate
            $class = (new \ReflectionClass($this))->getNamespaceName() . "\\" . self::convertToCamelCaseWithFirstUpperSymbol($property);
            // Update each element of the array to have the instantiated entity
            if (class_exists($class)) {
                $this->$property = new $class($value);
                return;
            }
        }
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    /**
     * @param string $str Snake case string
     *
     * @return string Camel case string
     */
    protected static function convertToCamelCase($str)
    {
        $callback = function ($match) {
            return strtoupper($match[2]);
        };
        return lcfirst(preg_replace_callback('/(^|_)([a-z])/', $callback, $str));
    }
    /**
     * @param string $str Snake case string
     *
     * @return string Camel case string with first Upper Symbol
     */
    protected static function convertToCamelCaseWithFirstUpperSymbol($str)
    {
        $callback = function ($match) {
            return strtoupper($match[2]);
        };
        return ucfirst(preg_replace_callback('/(^|_)([a-z])/', $callback, $str));
    }
    /**
     * Convert the entity to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $result = array();
        foreach ($this as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }
}