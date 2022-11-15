<?php

namespace src\Auxiliary;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * class LoadTemplate
 * Classe para carregamento do twig
 */
class LoadTemplate
{
    protected $twig;
    private $loader;

    private function loader()
    {
        $this->loader = new FilesystemLoader(PATH_VIEWS);
        return $this->loader;
    }

    public function init()
    {
        $twig = new Environment($this->loader(), [
            'debug' => true,
            'auto_reload' => true
        ]);
        return $twig;
    }
}
