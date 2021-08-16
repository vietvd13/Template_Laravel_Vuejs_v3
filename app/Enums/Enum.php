<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Date: 01/11/2020
 * Time: 22:51
 */

namespace Enum;

abstract class Enum
{
    private static $constCacheArray = NULL;

    private static function getConstants()
    {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            try {
                $reflect = new \ReflectionClass($calledClass);
                self::$constCacheArray[$calledClass] = $reflect->getConstants();
            } catch (\ReflectionException $e) {
            }
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function getLists($filter = [], $asocial = true)
    {
        $_list = [];
        foreach (self::getConstants() as $key => $value) {
            if (is_array($value) && count($value) == 2) {
                if ((!empty($filter['except']) && in_array($value[0], $filter['except']))
                    | (!empty($filter['only']) && !in_array($value[0], $filter['only']))) {
                    continue;
                }
                if (!$asocial) {
                    $_list[$value[0]] = trans($value[1]) ?? $value[1];
                    continue;
                }
                $_list[] = [
                    'id' => $value[0],
                    'value' => trans($value[1]) ?? $value[1]
                ];
            }
        }
        return $_list;
    }

    public static function getValue($const)
    {
        $constants = self::getConstants();
        foreach ($constants as $key => $value) {
            if (is_array($value) && count($value) && strtoupper($const) == strtoupper($key)) {
                return $value[0];
            }
        }
        return false;
    }

    public static function getDescription($value)
    {
        $constants = self::getConstants();
        foreach ($constants as $key => $val) {
            if (is_array($val) && count($val) == 2 && $value == $val[0]) {
                return !trans($val[1]) ? $val[1] : trans($val[1]);
            }
        }
        return false;
    }

    public static function getName($value)
    {
        $constants = self::getConstants();
        foreach ($constants as $key => $val) {
            if (is_array($val) && count($val) == 2 && $value == $val[0]) {
                return strtolower($key);
            }
        }
        return false;
    }
}
