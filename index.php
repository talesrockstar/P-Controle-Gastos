<?php

require_once 'vendor/autoload.php';

use Controller\UserController;

$userController = new UserController();
$loginMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = $userController->login($email, $password);
    if ($usuario) {
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: view/dashboard.php');
        exit();
    } else {
        $loginMessage = "Email ou senha incorretos";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Controle de Gastos Pessoais</title>
    <link rel="stylesheet" href="templates/assets/css/index.css">

    
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="logo">
                <h1>💰 Controle de Gastos</h1>
                <p>Gerencie suas finanças pessoais</p>
            </div>
            
            <form method="POST" class="auth-form">
                <h2>Entrar na sua conta</h2>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Entrar</button>
                
                <div class="auth-links">
                    <p>Não tem uma conta? <a href="view/cadastro.php">Criar conta</a></p>
                </div>
            </form>
            
            <p><?php echo $loginMessage; ?></p>
        </div>
    </div>
</body>
</html>

