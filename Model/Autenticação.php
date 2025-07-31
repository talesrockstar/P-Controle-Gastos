<?php

require_once 'Model/connection';

use Model\Connection;

class UsuarioController {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function registrar(string $usuario, string $senha): string {

        //Verifica se o usuario ja existe
        
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $existe = $stmt->fetchColumn();

        if($existe > 0) {
            return "Esse usuario ja esta sendo usado.";
        }

        if(!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $usuario)) {
            return("Nome de usuario inválido. Use apenas letras, numeros e sublinhado, entre (3 e 20 caracteres).");
        }
        //Validação do nome de usuario

        if(!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $usuario)) {
            return("Nome de usuario inválido. Use apenas letras, numeros e sublinhado, entre (3 e 20 caracteres).");
       }

    //Validação de senha forte
    if(
        strlen($senha) < 8 ||
        !preg_match('/[A-Z]/', $senha) ||
        !preg_match('/[a-z]/', $senha) ||
        !preg_match('/[0-9]/', $senha)
    ) {
        return("A senha deve ter no mínimo 8 caracteres, incluindo maiúscula, minúsculas e números.");
    }

    //Cria um hash seguro da senha
    $hashSenha = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
        $stmt->execute([$usuario, $hashSenha]);
        return "Usúario criado com sucesso!";
    }catch (PDOException $e) {
        return "Erro ao tentar registrar: " . $e->getMessage();
    }
}
}
//Execução

$usuario = 'usuarioTeste';
$senha = 'senhaTeste123';
$controller = new UsuarioController(connection::getInstance());
$resultado = $Controller->registrar($usuario, $senha);
echo $resultado;

?>