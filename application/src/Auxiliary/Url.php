<?php

namespace src\Auxiliary;

/**
 * class Url
 */
class Url
{
    public static function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
