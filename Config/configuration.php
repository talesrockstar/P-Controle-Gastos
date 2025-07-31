<?php
// Configuração do banco de dados
define("DB_HOST", "localhost");
define("DB_NAME", "lista_Compras"); //Mesmo nome do banco criado
define("DB_USER", "seu_usuario");
define("DB_PASS", "sua_senha");
define("DB_CATEGORY", [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
]);
define("DB_PORT", "3306");

?>