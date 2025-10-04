<?php

use PHPUnit\Framework\TestCase;

use Controller\DespesaController;

use Model\Despesa;

class DespesaTest extends TestCase {
    private $despesaController;

    private $mockDespesaModel;

    protected function setUp(): void {
        $this->mockDespesaModel = $this->createMock(Despesa::class);

        $this->despesaController = new DespesaController($this->mockDespesaModel);
    }

    public function testListar() {
        $this->despesaController->setUsuarioId(4);
        $this->mockDespesaModel->method('listarDespesasUsuario')->willReturn([[
            'id'=>1,
            'descricao'=>'Teste'
        ]]);
        $_GET['pagina'] = 1;
            $result = $this->despesaController->listar();
            $this->assertTrue($result['success']);
            $this->assertIsArray($result['data']);
    }

    public function testCriarComSucesso() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['descricao'] = 'Despesa Teste';
        $_POST['valor'] = 100;
        $_POST['categoria'] = 'alimentacao';
        $_POST['data'] = '2024-10-01';

        $this->despesaController->setUsuarioId(1);
        $this->mockDespesaModel->method('criarDespesa')->willReturn(true);

        $result = $this->despesaController->criar();
        $this->assertTrue($result['success']);
    }

    public function testCriarSemUsuarioId() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['descricao'] = 'Despesa Teste';
        $_POST['valor'] = 100;
        $_POST['categoria'] = 'alimentacao';
        $_POST['data'] = '2024-10-01';

        $result = $this->despesaController->criar();
        $this->assertFalse($result['success']);
    }

    public function testRelatorioComSucesso() {
        $this->despesaController->setUsuarioId(1);
        $this->mockDespesaModel->method('calcularTotalPeriodo')->willReturn(200.0);
        $this->mockDespesaModel->method('listarPorCategoria')->willReturn(['alimentacao'=>100]);

        $_GET['data_inicio'] = '2024-10-01';
        $_GET['data_fim'] = '2024-10-31';

        $result = $this->despesaController->relatorio();
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('data', $result);
    }

    public function testGetCategorias() {
        $categorias = $this->despesaController->getCategorias();
        $this->assertIsArray($categorias);
        $this->assertArrayHasKey('alimentacao', $categorias);
    }
}

?>

