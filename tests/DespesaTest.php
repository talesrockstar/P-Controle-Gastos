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

    public function testListarDespesa() {
        $this->despesaController->setUsuarioId(1);
        $this->mockDespesaModel->method('listarDespesasUsuario')->willReturn([[
            'id'=>1,
            'descricao'=>'Teste'
        ]]);
        $_GET['pagina'] = 1;
            $despesaResult = $this->despesaController->listar();
            $this->assertTrue($despesaResult['success']);
            $this->assertIsArray($despesaResult['data']);
    }

    public function testCriarDespesaComSucesso() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['descricao'] = 'Despesa Teste';
        $_POST['valor'] = 100;
        $_POST['categoria'] = 'alimentacao';
        $_POST['data'] = '2024-10-01';

        $this->despesaController->setUsuarioId(1);
        $this->mockDespesaModel->method('criarDespesa')->willReturn(true);

        $despesaResult = $this->despesaController->criar();
        $this->assertTrue($despesaResult['success']);
        $this->assertEquals("Despesa criada com sucesso", $despesaResult['message']);
    }

    
    public function testCriarDespesaSemDescricao() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['descricao'] = ''; // Campo obrigatório vazio!
        $_POST['valor'] = 100; 
        $_POST['categoria'] = 'alimentacao';
        $_POST['data'] = '2024-10-01';

        $this->despesaController->setUsuarioId(1);

        $despesaResult = $this->despesaController->criar();
        $this->assertFalse($despesaResult['success']);
        $this->assertEquals("Descrição deve ter pelo menos 3 caracteres", $despesaResult['message']);
    }


    public function testCriarDespesaSemValor() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['descricao'] = 'Despesa Teste';
        $_POST['valor'] = null; // Campo obrigatório vazio!
        $_POST['categoria'] = 'alimentacao';
        $_POST['data'] = '2024-10-01';

        $this->despesaController->setUsuarioId(1);

        $despesaResult = $this->despesaController->criar();
        $this->assertFalse($despesaResult['success']);
        $this->assertEquals("Valor deve ser informado", $despesaResult['message']);
    }

    // public function testCriarDespesaSemValor() {
    //     $_SERVER['REQUEST_METHOD'] = 'POST';
    //     $_POST['descricao'] = 'Despesa Teste';
    //     $_POST['valor'] = null;   // Campo obrigatório vazio!
    //     $_POST['categoria'] = 'alimentacao';
    //     $_POST['data'] = '2024-10-01';

    //     $this->despesaController->setUsuarioId(1);

    //     $despesaResult = $this->despesaController->criar();
    //     $this->assertFalse($despesaResult['success']);
    //     $this->assertEquals("Todos os campos são obrigatórios", $despesaResult['message']);
    // }

    public function testCriarDespesaSemCategoria() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['descricao'] = 'Despesa Teste';
        $_POST['valor'] = 100;   
        $_POST['categoria'] = ''; // Campo obrigatório vazio!
        $_POST['data'] = '2024-10-01';

        $this->despesaController->setUsuarioId(1);

        $despesaResult = $this->despesaController->criar();
        $this->assertFalse($despesaResult['success']);
        $this->assertEquals("A categoria deve ser informada", $despesaResult['message']);
    }

    public function testCriarDespesaSemData() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['descricao'] = 'Despesa Teste';
        $_POST['valor'] = 100; 
        $_POST['categoria'] = 'alimentacao';
        $_POST['data'] = ''; // Campo obrigatório vazio!

        $this->despesaController->setUsuarioId(1);

        $despesaResult = $this->despesaController->criar();
        $this->assertFalse($despesaResult['success']);
        $this->assertEquals("Data inválida", $despesaResult['message']);
    }

    public function testCriarSemUsuarioId() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['descricao'] = 'Despesa Teste';
        $_POST['valor'] = 100;
        $_POST['categoria'] = 'alimentacao';
        $_POST['data'] = '2024-10-01';

        $despesaResult = $this->despesaController->criar();
        $this->assertFalse($despesaResult['success']);
        $this->assertEquals("ID do usuário não definido para criação de despesa.", $despesaResult['message']);
    }

    public function testRelatorioComSucesso() {
        $this->despesaController->setUsuarioId(1);
        $this->mockDespesaModel->method('calcularTotalPeriodo')->willReturn(200.0);
        $this->mockDespesaModel->method('listarPorCategoria')->willReturn(['alimentacao'=>100]);

        $_GET['data_inicio'] = '2024-10-01';
        $_GET['data_fim'] = '2024-10-31';

        $despesaResult = $this->despesaController->relatorio();
        $this->assertTrue($despesaResult['success']);
        $this->assertArrayHasKey('data', $despesaResult);
    }

    
    public function testListarDespesaSemGastos() {
        $this->despesaController->setUsuarioId(1);
        $this->mockDespesaModel->method('listarDespesasUsuario')->willReturn([]); // Nenhum gasto

        $_GET['pagina'] = 1;
        $despesaResult = $this->despesaController->listar();

        $this->assertFalse($despesaResult['success']);
        $this->assertEquals("Nenhum gasto cadastrado", $despesaResult['message']);
    }

    public function testGetCategorias() {
        $categorias = $this->despesaController->getCategorias();
        $this->assertIsArray($categorias);
        $this->assertArrayHasKey('alimentacao', $categorias);
    }
}

?>

