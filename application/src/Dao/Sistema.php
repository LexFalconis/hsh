<?php

namespace src\Dao;

use Exception;
use PDO;
use src\Entity\Sistema as SistemaEntity;
use src\Exception\NotFoundException;

class Sistema
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retorna todos os sistemas cadastrados com base no status
     * @return array|false|void
     */
    public function findAllByStatus($status)
    {
        try {
            $pdo = $this->pdo;
            $sql = "select * from sistema where status = {$status}";
            $result = $pdo->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Ocorreu um erro: " . PHP_EOL . $e->getMessage();
        }
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function findById($id)
    {
        try {
            $pdo = $this->pdo;
            $sql = 'select * from sistema where id = :id';
            $prepare = $pdo->prepare($sql);
            $prepare->bindValue(":id", $id, PDO::PARAM_INT);
            $prepare->execute();

            $data = $prepare->fetch(PDO::FETCH_ASSOC);

            if (false === $data) {
                throw new NotFoundException();
            }
            return $data;
        } catch (NotFoundException $e) {
            throw new NotFoundException('Não foi encontrado nenhum registro com o Id ' . $id);
        } catch (Exception $e) {
            echo "Ocorreu um erro: " . PHP_EOL . $e->getMessage();
        }
    }

    /**
     * @param $dados
     * @return bool|string
     */
    public function persist($dados)
    {
        if (key_exists('id', $dados) and !empty($dados['id'])) {
            return $this->update($dados);
        }
        return $this->insert($dados);
    }

    /**
     * @param $dados
     * @return bool
     */
    public function update ($dados)
    {
        try {
            $sql = "
                UPDATE sistema set
                nome = :nome,
                link = :link,
                status = :status,
                descricao = :descricao
                WHERE id = :id
            ";
            $pdo = $this->pdo;
            $prepare = $pdo->prepare($sql);

            $prepare->bindValue(":nome", $dados['nome']);
            $prepare->bindValue(":link", $dados['link']);
            $prepare->bindValue(":status", $dados['status']);
            $prepare->bindValue(":descricao", $dados['descricao']);
            $prepare->bindValue(":id", $dados['id']);

            return $prepare->execute();
        } catch (Exception $e) {
            throw new \DomainException("Ocorreu um erro ao tentar executar a atualização dos dados. " . $e->getMessage());
        }
    }

    /**
     * @param $dados
     * @return false|string
     */
    public function insert ($dados)
    {
        try {
            $sql = "
                INSERT INTO sistema (
                    nome,
                    link,
                    descricao
                )
                VALUES (
                    :nome,
                    :link,
                    :descricao
                )
            ";

            $pdo = $this->pdo;
            $prepare = $pdo->prepare($sql);

            $prepare->bindValue(":nome", $dados['nome']);
            $prepare->bindValue(":link", $dados['link']);
            $prepare->bindValue(":descricao", $dados['descricao']);

            $prepare->execute();

            return $pdo->lastInsertId();
        } catch (Exception $e) {
            throw new \DomainException("Ocorreu um erro ao tentar executar a inserção dos dados. " . $e->getMessage());
        }
    }

    /**
     * Altera o status de um sistema para inativo
     * @param $id
     * @return bool
     */
    public function disable ($id)
    {
        return $this->updateStatus($id, SistemaEntity::STATUS_INATIVO);
    }

    /**
     * Altera o status de um sistema para ativo
     * @param $id
     * @return bool
     */
    public function enable ($id)
    {
        return $this->updateStatus($id, SistemaEntity::STATUS_ATIVO);
    }

    /**
     * @param $id
     * @param $status
     * @return bool
     */
    private function updateStatus ($id, $status)
    {
        try {
            $sql = "
                UPDATE sistema set
                status = :status
                WHERE id = :id
            ";
            $pdo = $this->pdo;
            $prepare = $pdo->prepare($sql);

            $prepare->bindValue(":status", $status);
            $prepare->bindValue(":id", $id);

            return $prepare->execute();
        } catch (Exception $e) {
            throw new \DomainException("Ocorreu um erro ao tentar executar a atualização dos dados. " . $e->getMessage());
        }
    }

    /**
     * Deleta um registro com base no id
     * @param $id
     * @return bool
     */
    public function remove ($id)
    {
        try {
            $sql = "DELETE FROM sistema WHERE id = :id";
            $pdo = $this->pdo;
            $prepare = $pdo->prepare($sql);

            $prepare->bindValue(":id", $id);

            return $prepare->execute();
        } catch (Exception $e) {
            throw new \DomainException("Ocorreu um erro ao tentar executar a remoção dos dados. " . $e->getMessage());
        }
    }
}
