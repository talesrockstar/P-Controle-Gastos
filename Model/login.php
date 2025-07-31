<?php

require_once 'Model/connection.php';

session_start();

use Model\Connection;

header('Content-Type: application/json');

class UsuarioController {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function login(string $usuario, string $senha): array {
        if (!$usuario || !$senha) {
           return(["status" => "erro", "mensagem" => "Usuário e senha são obrigatórios"]);
    }

    try {
      $stmt = $this->pdo->prepare("SELECT id, senha FROM usuarios WHERE usuario = ?");
      $stmt->execute([$usuario]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      
    if ($user && password_verify($senha, $user['senha'])) {
        //Login ok, armazena na sessão

        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $usuario;

        return(["status" => "ok", "mensagem" => "Login realizado com sucesso"]);
    } else {
        return(["status" => "erro", "mensagem" => "Usúario ou senha inválidas"]);
    }
}catch (PDOException $e) {
    return(["status" => "erro", "mensagem" => "Erro no servidor: " . $e->getMessage()]);
}
}
}
//Execução

$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data['usuario'] ?? '';
$senha = $data['senha'] ?? '';

$controller = new UsuarioController(Connection::getInstance());
$response = $controller->login($usuario, $senha);
echo json_encode($response);

?>