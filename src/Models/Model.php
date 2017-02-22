<?php

namespace zvook\PostgreStat\Models;

/**
 * @package zvook\PostgreStat\Models
 * @author Dmitry zvook Klyukin
 */
abstract class Model
{
    /**
     * @param array $params
     */
    function __construct(array $params = [])
    {
        if (!empty($params)) {
            foreach ($params as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    /**
     * @return array
     */
    public final function asArray()
    {
        $params = [];
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PROTECTED);
        foreach ($props as $prop) {
            $propName = $prop->getName();
            $propValue = $this->$propName;
            if (!is_null($propValue)) {
                $params[$propName] = $this->$propName;
            }
        }

        return $params;
    }

    /**
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }
}