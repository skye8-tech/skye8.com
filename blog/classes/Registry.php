<?php

/**
 * Class Registry
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

class Registry{

    /**
     * @var array
     */
    private static $values = array();

    /**
     * @param $key
     * @param null $value
     */
    public static function set($key, $value = null) {
        self::$values[$key] = $value;
    }

    /**
     * @param $key
     * @return null
     */
    public static function get($key) {
        return isset(self::$values[$key]) ? self::$values [$key] : null;
    }

    /**
     * @param $key
     */
    public static function remove($key) {
        unset(self::$values[$key]);
    }
}