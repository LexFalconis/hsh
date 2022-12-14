<?php

namespace src\Pdo;

use PDO;

class Connection
{

    public static $instance;

    /**
     * Retorna uma instância do PDO
     * @return PDO
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $password = getenv('MYSQL_PASSWORD');
            $user = getenv('MYSQL_USER');
            $host = getenv('MYSQL_HOST');
            $dbName = getenv('MYSQL_DATABASE');

            self::$instance = new PDO(
                "mysql:host=$host;dbname=$dbName",
                $user,
                $password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS,
                PDO::NULL_EMPTY_STRING);
        }

        return self::$instance;
    }
}
