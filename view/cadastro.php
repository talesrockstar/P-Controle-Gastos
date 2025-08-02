<?php
require_once '../vendor/autoload.php';

use Controller\UserController;

$userController = new UserController();

$registerUserMessage = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $user_fullname = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if($userController->checkUserByEmail($email)) {
            $registerUserMessage = "Já existe um usuário cadastrado com esse endereço de e-mail.";
        } else {

            if($userController->createUser($user_fullname, $email, $password)) {
                header('Location: ../index.php');
                exit();
            } else {
                $registerUserMessage = 'Erro ao registrar informações.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Controle de Gastos Pessoais</title>
    <link rel="stylesheet" href="../templates/assets/css/cadastro.css">

</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="logo">
                <h1>💰 Controle de Gastos</h1>
                <p>Gerencie suas finanças pessoais</p>
            </div>
            
            <form method="POST" class="auth-form">
                <h2>Criar sua conta</h2>
                
                <div class="form-group">
                    <label for="name">Nome completo</label>
                    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>
                
                <button type="submit" class="btn btn-primary">Criar conta</button>
                
                <div class="auth-links">
                    <p>Já tem uma conta? <a href="../index.php">Fazer login</a></p>
                </div>
            </form>
            
            <p> <?php echo $registerUserMessage; ?> </p>
        </div>
    </div>
</body>
</html>

