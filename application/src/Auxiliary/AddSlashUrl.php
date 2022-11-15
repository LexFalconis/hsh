<?php

namespace src\Auxiliary;

/**
 * class AddSlashUrl
 * Classe que adicionar por padrão uma barra no final da URL
 * para auxiliar na identificação das controllers e métodos
 */
class AddSlashUrl
{
    public function __invoke()
    {
        if($_SERVER['REQUEST_URI'] != '/') {
            return $_SERVER['REQUEST_URI'] . DIRECTORY_SEPARATOR;
        }
    }
}
