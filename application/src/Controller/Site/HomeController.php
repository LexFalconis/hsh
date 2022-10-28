<?php

namespace src\Controller\Site;

use src\Controller\BaseController;
use src\Repository\Sistema;

class HomeController extends BaseController
{
    public function index()
    {
        $sistemas = (new Sistema($this->getPdo()))->findAllActive();
        $dados = [
            'system_name' => 'Home Sweet Home',
            'titulo' => 'Home',
            'sistemas' => $sistemas
        ];
        $template = $this->twig->loadTemplate('home.html.twig');
        $template->display($dados);
    }
}
