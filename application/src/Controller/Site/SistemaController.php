<?php

namespace src\Controller\Site;

use src\Controller\BaseController;
use src\Controller\Tools\WkhtmlController;
use src\Repository\Sistema;

/**
 * class SistemaController
 * Controller responsável pelo crud da entidade sistema
 */
class SistemaController extends BaseController
{
    /**
     * @return void
     */
    public function index()
    {
        header("Location:/home");
    }

    public function inative()
    {
        $sistemas = (new Sistema($this->getPdo()))->findAllInative();
        $mensagem = null;
        if($sistemas->count() == 0) {
            $mensagem = "
                Hummmm, não temos nenhum link/sistema com status 'Inativo'.
                Clica ali no botão do lado superior esquerdo p voltar para a Home, tá bem?
            ";
        }
        $dados = [
            'mensagem' => $mensagem,
            'system_name' => 'Home Sweet Home',
            'titulo' => 'Home',
            'sistemas' => $sistemas
        ];
        $template = $this->twig->load('home.html.twig');
        echo $template->render($dados);
    }

    /**
     * Responsável pela apresentação de um item da entidade Id
     * @return void
     */
    public function view()
    {
        try {
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
            $template = $this->twig->load('sistema/view.html.twig');
            echo $template->render($dados);
        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    /**
     * @return void
     */
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
                $template = $this->twig->load('sistema/form.html.twig');
                echo $template->render($dados);
                exit();
            }

            $sistemaRepository->persist($_POST);
            $wkhtml = new WkhtmlController();
            $wkhtml->urlToImage($_POST['link'], $id);

            header("Location:/sistema/view/id=$id");

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    /**
     * Exibe a tela de cadastro para a entidade sistema
     * @return void
     */
    public function create()
    {
        try {
            $dados = [
                'system_name' => 'Home Sweet Home',
                'titulo' => 'Cadastro'
            ];
            $template = $this->twig->load('sistema/form.html.twig');
            echo $template->render($dados);

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    /**
     * Cadastra um novo "sistema"
     * @return void
     */
    public function insert()
    {
        try {
            $sistemaRepository = new Sistema($this->getPdo());

            $id = $sistemaRepository->persist($_POST);

            $wkhtml = new WkhtmlController();
            $wkhtml->urlToImage($_POST['link'], $id);
            header("Location:/sistema/view/id=$id");

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    /**
     * Deleta um sistema e remove a sua imagem dos arquivos
     * @return void
     */
    public function remove()
    {
        $id = $this->getId();
        if ($id == false) {
            $_SESSION['mensagem'] = 'Não é possível remover um item que não possui id.';
            header("Location:/genericError");
        }
        try {
            $sistemaRepository = new Sistema($this->getPdo());

            if($sistemaRepository->remove($id)) {
                $wkhtml = new WkhtmlController();
                $wkhtml->removeImageById($id);
            }

            header("Location:/home");

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    /**
     * Altera o status de um sistema para inativo
     * @return void
     */
    public function disable()
    {
        $id = $this->getId();
        if ($id == false) {
            $_SESSION['mensagem'] = 'Não é possível desativar um item que não possui id.';
            header("Location:/genericError");
        }
        try {
            $sistemaRepository = new Sistema($this->getPdo());

            $sistemaRepository->disable($id);

            header("Location:/home");

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }

    /**
     * Altera o status de um sistema para ativo
     * @return void
     */
    public function enable()
    {
        $id = $this->getId();
        if ($id == false) {
            $_SESSION['mensagem'] = 'Não é possível reativar um item que não possui id.';
            header("Location:/genericError");
        }
        try {
            $sistemaRepository = new Sistema($this->getPdo());

            $sistemaRepository->enable($id);

            header("Location:/sistema/view/id=$id");

        } catch (\Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header("Location:/genericError");
        }
    }
}
