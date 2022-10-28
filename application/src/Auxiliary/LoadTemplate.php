<?php

namespace src\Auxiliary;

class LoadTemplate
{
    protected $twig;
    private $loader;

    private function loader()
    {
        $this->loader = new \Twig_Loader_Filesystem(PATH_VIEWS);
        return $this->loader;
    }

    public function init()
    {
        $twig = new \Twig_Environment($this->loader(), array(
            'debug' => true,
            //'cache' => ROOT.'/cache/',
            'auto_reload' => true
        ));
        return $twig;
    }
}
