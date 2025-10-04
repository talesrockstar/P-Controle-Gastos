<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Config/configuration.php';
require_once __DIR__ . '/../Controller/DespesaController.php';
require_once __DIR__ . '/../Model/Despesa.php';

use Model\Despesa;
use Controller\DespesaController;

$despesaModel = new Despesa();
$despesaController = new DespesaController($despesaModel);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}
$usuarioId = $_SESSION['usuario_id'];
$usuarioNome = $_SESSION['usuario_nome'] ?? 'Usuário';

// Definir o ID do usuário no controller
$despesaController->setUsuarioId($usuarioId);

$pagina = (int)($_GET['pagina'] ?? 1);
$limite = 10;

$despesas = $despesaController->listar();

$despesasPaginadas = $despesas['data'] ?? [];

$totalDespesas = count($despesasPaginadas);
$totalPaginas = ceil($totalDespesas / $limite);

$relatorio = $despesaController->relatorio();
$totalGeral = $relatorio['data']['total_geral'] ?? 0;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Despesas - Controle de Gastos Pessoais</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../templates/assets/css/ver-despesas.css">
    <link rel="stylesheet" href="../templates/assets/css/components.css">
</head>
<body>
    <div class="app-container">
        <header class="header">
            <div class="header-content">
                <h1>💰 Controle de Gastos</h1>
                <div class="user-info">
                    <a href="../index.php" id="logoutBtn" class="btn btn-secondary">🚪 Sair</a>
                </div>
            </div>
        </header>
        
        <nav class="nav-breadcrumb">
            <a href="dashboard.php">🏠 Dashboard</a> > <span>📊 Ver Despesas</span>
        </nav>
        
        <main class="main-content">
            <div class="page-header">
                <div>
                    <h2>📊 Suas Despesas</h2>
                    <p style="color: #6b7280; margin-top: 0.5rem; font-size: 1.1rem;">Gerencie e visualize todos os seus gastos</p>
                </div>
                <div class="header-actions">
                    <a href="criar-despesa.php" class="btn btn-primary">✨ Nova Despesa</a>
                </div>
            </div>
            
            <div class="expenses-container">
                <div id="expensesList" class="expenses-list">
                    <?php if (!empty($despesasPaginadas)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Categoria</th>
                                    <th>Data da Despesa</th>
                                    <th>Data de Criação</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($despesasPaginadas as $despesa): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($despesa['descricao']); ?></td>
                                        <td>R$ <?php echo number_format($despesa['valor'], 2, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($despesa['categoria']); ?></td>
                                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($despesa['data_despesa']))); ?></td>
                                        <td><?php echo htmlspecialchars(date('d/m/Y H:i:s', strtotime($despesa['data_criacao']))); ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if ($totalPaginas > 1): ?>
                            <div class="pagination">
                                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                    <a href="?pagina=<?php echo $i; ?>" class="btn <?php echo ($i == $pagina) ? 'btn-primary' : 'btn-secondary'; ?>"><?php echo $i; ?></a>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div id="emptyState" class="empty-state">
                            <a href="criar-despesa.php" class="btn btn-primary">🚀 Criar primeira despesa</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

