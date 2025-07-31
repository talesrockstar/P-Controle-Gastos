<?php

require_once 'Model/connection.php';

use Model\Connection;

header('Content-Type: application/json');

class CategoriaController {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

public function listar(): array {

try {
    //Selencionar categorias distintas
    $stmt = $this->pdo->query("SELECT DISTINCT categoria FROM itens ORDER BY categoria ASC");
    $categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return([
        "status" => "ok",
        "categorias" => $categorias
    ]);
} catch (Exception $e) {
    return([
        "status" => "erro",
        "mensagem" => "Erro ao buscar categorias: " . $e->getMessage()
    ]);
}
}
}
$controller = new CategoriaController(connection::getInstance());
$response = $Controller->listar();
echo json_encode($response);
?>