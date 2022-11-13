<?php

namespace src\Dao;

use Exception;
use PDO;

class Sistema
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllActive()
    {
        try {
            $pdo = $this->pdo;
            $sql = 'select * from sistema where status = true';
            $result = $pdo->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Ocorreu um erro: " . PHP_EOL . $e->getMessage();
        }
    }

    public function findById($id)
    {
        try {
            $pdo = $this->pdo;
            $sql = 'select * from sistema where id = :id';
            $prepare = $pdo->prepare($sql);
            $prepare->bindValue(":id", $id, PDO::PARAM_INT);
            $prepare->execute();
            return $prepare->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Ocorreu um erro: " . PHP_EOL . $e->getMessage();
        }
    }

    public function persist($dados)
    {
        if (key_exists('id', $dados) and !empty($dados['id'])) {
            return $this->update($dados);
        }
        return $this->insert($dados);
    }

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

    public function remove ($id)
    {
        try {
            $sql = "
                UPDATE sistema set
                status = :status
                WHERE id = :id
            ";
            $pdo = $this->pdo;
            $prepare = $pdo->prepare($sql);

            $prepare->bindValue(":status", \src\Entity\Sistema::STATUS_INATIVO);
            $prepare->bindValue(":id", $id);

            return $prepare->execute();
        } catch (Exception $e) {
            throw new \DomainException("Ocorreu um erro ao tentar executar a atualização dos dados. " . $e->getMessage());
        }
    }
}
