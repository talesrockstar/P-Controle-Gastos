<?php

require_once 'Model/connection.php';

use Model\Connection;

class ItemController {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function excluir(array $data): array {
        $id = $data['id'] ?? null;

        if ($id === null) {
            return(["status" => "erro", "mensagem" => "ID não foi enviado"]);
    }
    try {
        $stmt = $this->pdo->prepare("DELETE FROM itens WHERE id = ?");
        $stmt->execute([$id]);
        return(["status" => "ok"]);
    }catch (PDOException $e) {
        return(["status" => "erro", "mensagem" => "Erro ao tentar excluir"]);
}
    }
}

$data = json_decode(file_get_contents("php://input"), true);
$controller = new ItemController(Connection::getInstance());
$response = $controller->excluir($data);
echo json_encode($response);

?>