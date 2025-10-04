<?php
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . 
'/../Config/configuration.php';
require_once __DIR__ . 
'/../Controller/DespesaController.php';
require_once __DIR__ . '/../Model/Despesa.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Model\Despesa;
use Controller\DespesaController;

$despesaModel = new Despesa();
$despesaController = new DespesaController($despesaModel);

$usuarioId = $_SESSION['usuario_id'] ?? 1;
$usuarioNome = $_SESSION['usuario_nome'] ?? 'Usuário Teste';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW);
    $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_UNSAFE_RAW);
    $data = filter_input(INPUT_POST, 'data', FILTER_UNSAFE_RAW);

    if (empty($descricao) || $valor === false || empty($categoria) || empty($data)) {
        $message = 'Todos os campos são obrigatórios.';
        $messageType = 'error';
    } elseif (strlen($descricao) < 3) {
        $message = 'Descrição deve ter pelo menos 3 caracteres.';
        $messageType = 'error';
    } elseif ($valor <= 0) {
        $message = 'Valor deve ser maior que zero.';
        $messageType = 'error';
    } else {
        // Defina o usuário logado no controller antes de chamar criar()
        $despesaController->setUsuarioId($usuarioId);

        $result = $despesaController->criar();

        if ($result['success']) {
            header('Location: ver-despesas.php');
            exit();
        } else {
            $message = $result['message'] ?? 'Erro ao criar despesa. Tente novamente.';
            $messageType = 'error';
        }
    }
}

$categorias = $despesaController->getCategorias();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Despesa - Controle de Gastos Pessoais</title>
    <link rel="stylesheet" href="../templates/assets/css/criar-despesa.css">
    <link rel="stylesheet" href="../templates/assets/css/components.css">
</head>
<body>
    <div class="app-container">
        <header class="header">
            <div class="header-content">
                <h1>💰 Controle de Gastos</h1>
                <div class="user-info">
                    <a href="../index.php" class="btn btn-secondary">🚪 Sair</a>
                </div>
            </div>
        </header>
        <main class="main-content">
            <div class="page-header">
                <h2>✨ Criar Nova Despesa</h2>
                <p>Preencha os dados da sua despesa de forma rápida e intuitiva</p>
            </div>
            <div class="form-container">
                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <form class="expense-form" method="POST">
                    <div class="form-group">
                        <label for="expenseName">💼 Nome da Despesa</label>
                        <input type="text" id="expenseName" name="descricao" required 
                               placeholder="Ex: Supermercado Extra, Combustível Shell, Restaurante..." value="<?php echo htmlspecialchars($_POST['descricao'] ?? ''); ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expenseValue">💰 Valor (R$)</label>
                            <input type="number" id="expenseValue" name="valor" required 
                                   step="0.01" min="0" placeholder="0,00" value="<?php echo htmlspecialchars($_POST['valor'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="expenseDate">📅 Data da Despesa</label>
                            <input type="date" id="expenseDate" name="data" required value="<?php echo htmlspecialchars($_POST['data'] ?? date('Y-m-d')); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="expenseCategory">🏷️ Categoria</label>
                        <select id="expenseCategory" name="categoria" required>
                            <option value="">Selecione uma categoria</option>
                            <?php foreach ($categorias as $value => $label): ?>
                                <option value="<?php echo $value; ?>" <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == $value) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='dashboard.php'">
                            ❌ Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            💾 Salvar Despesa
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

