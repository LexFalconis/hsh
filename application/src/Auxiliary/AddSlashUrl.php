<?php

namespace src\Auxiliary;

class AddSlashUrl
{
    public function __invoke()
    {
        if($_SERVER['REQUEST_URI'] != '/') {
            return $_SERVER['REQUEST_URI'] . DIRECTORY_SEPARATOR;
        }
    }
}
