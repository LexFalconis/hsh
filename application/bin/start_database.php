#!/usr/bin/php
<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor/autoload.php";
define("ROOT_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);

try {
    $repository = Dotenv\Repository\RepositoryBuilder::createWithNoAdapters()
        ->addAdapter(Dotenv\Repository\Adapter\EnvConstAdapter::class)
        ->addWriter(Dotenv\Repository\Adapter\PutenvAdapter::class)
        ->immutable()
        ->make();

    $dotenv = Dotenv\Dotenv::create($repository, ROOT_PATH);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $exception) {
    printf("%s\n", $exception->getMessage());
    die();
}

$pdo = \src\Pdo\Connection::getInstance();

try {
    $sql = "
        CREATE TABLE IF NOT EXISTS `hsh`.`sistema` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `nome` VARCHAR(45) NOT NULL,
            `link` VARCHAR(255) NOT NULL,
            `descricao` VARCHAR(255) NOT NULL,
            `status` TINYINT NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
        )
    ";
    $pdo->exec($sql);
    echo "Tabela 'sistema' criada com sucesso." . PHP_EOL;

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

    $prepare = $pdo->prepare($sql);

    $prepare->bindValue(":nome", "Site/sistema teste");
    $prepare->bindValue(":link", "https://www.globo.com/ ");
    $prepare->bindValue(":descricao", "Registro de exemplo.");

    $prepare->execute();
    echo "Registro de exemplo criado com sucesso." . PHP_EOL;

} catch (PDOException $e) {
    echo "Ocorreu um erro: " . $e->getMessage() . PHP_EOL;
}
