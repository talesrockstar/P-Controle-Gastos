<?php
//Configurações de uso
//Exemplo de uso em outras classes = use Model\Connection;
namespace Model;

//Importação para conexão com banco de dados

use PDO;
use PDOException;

require__DIR__ ."/../Config/configuration.php";
   class Connection {
    //Atributo estático que irá permitir a conexão abaixo
    private static $pdo;

    public static function getInstance(): PDO {
        // Criar uma nova conxão somente se ela não existir
    if (!isset(self::$pdo)) {
        try {
           self::$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT, DB_USER, DB_PASS, DB_CATEGORY);
           self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro ao tentar estabelecer uma conexão: " . $e->getMessage());
        }
    }
      return self::$pdo;
    }
   }
?>