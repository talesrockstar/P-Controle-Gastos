<?php

class ItemController {

private PDO $pdo;

public function __construct(PDO $pdo) {
    $this->pdo;
}

public function adicionar(array $data): array {

$usuario = $data['usuario'] ?? '';
$categoria = $data['categoria'] ?? '';
$item = $data['item'] ?? '';

if(!$usuario || !$categoria || !$item) {
    return(["status" => "erro", "mensagem" => "Os dados estão incompletos!"]);
}
if($usuario && $categoria && $item) {
    if(strlen($item) > 255) {
        return(["status" => "erro", "mensagem" => "Item muito longo"]);
    }
    try{
    $stmt = $pdo->prepare("INSERT INTO itens (usuario, categoria, item) VALUES (?, ?, ?)");
    $stmt->execute([$usuario, $categoria, $item]);
    return(["status" => "ok"]);
}catch (PDOException $e) {
    return(["status" => "erro", "mensagem" => "Erro ao tentar colocar no banco"]);
}
}
}
}

require_once 'Model/connection.php';

use Model\Connection;

$data = json_decode(file_get_contents("php://input"), true);
$controller = new ItemController(Connection::getInstance());
$response = $controller->adicionar($data);
echo json_encode($response);
?>