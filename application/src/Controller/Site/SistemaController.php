<?php

namespace src\Controller\Site;

use src\Controller\BaseController;
use src\Repository\Sistema;

class SistemaController extends BaseController
{
    public function index()
    {
        header("Location:/home");
    }

    public function view()
    {
        $id = $this->getId();
        if ($id == false) {
            header("Location:/genericError");
        }
        $sistema = (new Sistema($this->getPdo()))->findById($id);

        $dados = [
            'system_name' => 'Home Sweet Home',
            'titulo' => 'Visualização',
            'sistema' => $sistema
        ];
        $template = $this->twig->loadTemplate('sistema/view.html.twig');
        $template->display($dados);
    }

    public function edit()
    {
        $id = $this->getId();
        if ($id == false) {
            $_SESSION['mensagem'] = 'Não é possível editar um item que não possui id.';
            header("Location:/genericError");
        }
        try {
            $sistemaRepository = new Sistema($this->getPdo());

            if (
                !key_exists('id', $_POST) and
                !key_exists('nome', $_POST)
            ) {
                $sistema = $sistemaRepository->findById($id);

                $dados = [
                    'system_name' => 'Home Sweet Home',
                    'titulo' => 'Edição',
                    'sistema' => $sistema
                ];
                $template = $this->twig->loadTemplate('sistema/form.html.twig');
                $template->display($dados);
            }

            $sistemaRepository->persist($_POST);

            header("Location:/sistema/view/id=$id");

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    public function create()
    {
        try {
            $dados = [
                'system_name' => 'Home Sweet Home',
                'titulo' => 'Cadastro'
            ];
            $template = $this->twig->loadTemplate('sistema/form.html.twig');
            $template->display($dados);

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    public function insert()
    {
        try {
            $sistemaRepository = new Sistema($this->getPdo());

            $id = $sistemaRepository->persist($_POST);

            header("Location:/sistema/view/id=$id");

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    public function remove()
    {
        $id = $this->getId();
        if ($id == false) {
            $_SESSION['mensagem'] = 'Não é possível remover um item que não possui id.';
            header("Location:/genericError");
        }
        try {
            $sistemaRepository = new Sistema($this->getPdo());

            $sistemaRepository->remove($id);

            header("Location:/home");

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }
}
