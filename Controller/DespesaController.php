<?php

namespace Controller;

use Model\Despesa;


class DespesaController
{
    private $despesaModel;
    private $usuarioId;

    public function __construct(Despesa $despesaModel)
    {
        $this->despesaModel = $despesaModel;
    }

    public function setUsuarioId(int $usuarioId): void
    {
        $this->usuarioId = $usuarioId;
    }

    

    public function listar(): array
    {
        $pagina = (int)($_GET["pagina"] ?? 1);
        $limite = 20;
        $offset = ($pagina - 1) * $limite;

        $despesas = $this->despesaModel->listarDespesasUsuario($this->usuarioId, $limite, $offset);

        return [
            "success" => true,
            "data" => $despesas,
            "pagina_atual" => $pagina
        ];
    }

    
    public function criar(): array
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return [
                "success" => false,
                "message" => "Método não permitido"
            ];
        }

        // O usuarioId é definido via setUsuarioId antes de chamar este método
        if (!isset($this->usuarioId)) {
            return [
                "success" => false,
                "message" => "ID do usuário não definido para criação de despesa."
            ];
        }

        $descricao = $_POST['descricao'] ?? filter_input(INPUT_POST, "descricao", FILTER_UNSAFE_RAW);
        $valor = $_POST['valor'] ?? filter_input(INPUT_POST, "valor", FILTER_VALIDATE_FLOAT);
        $categoria = $_POST['categoria'] ?? filter_input(INPUT_POST, "categoria", FILTER_UNSAFE_RAW);
        $data = $_POST['data'] ?? filter_input(INPUT_POST, "data", FILTER_UNSAFE_RAW);

        $validacao = $this->validarDadosDespesa($descricao, $valor, $categoria, $data);
        if (!$validacao["valido"]) {
            return [
                "success" => false,
                "message" => $validacao["mensagem"]
            ];
        }

        if ($this->despesaModel->criarDespesa($this->usuarioId, $descricao, $valor, $categoria, $data)) {
            return [
                "success" => true,
                "message" => "Despesa criada com sucesso",
                "redirect" => "listar-despesas.php"
            ];
        } else {
            return [
                "success" => false,
                "message" => "Erro ao criar despesa. Tente novamente."
            ];
        }
    }


    public function relatorio(): array
    {
        if (!isset($this->usuarioId)) {
            return [
                "success" => false,
                "message" => "ID do usuário não definido para gerar relatório."
            ];
        }

        $dataInicio = $_GET["data_inicio"] ?? date("Y-m-01");
        $dataFim = $_GET["data_fim"] ?? date("Y-m-t");

        if (!$this->validarData($dataInicio) || !$this->validarData($dataFim)) {
            return [
                "success" => false,
                "message" => "Datas inválidas"
            ];
        }

        $totalGeral = $this->despesaModel->calcularTotalPeriodo($this->usuarioId, $dataInicio, $dataFim);
        $gastosPorCategoria = $this->despesaModel->listarPorCategoria($this->usuarioId, $dataInicio, $dataFim);

        return [
            "success" => true,
            "data" => [
                "periodo" => [
                    "inicio" => $dataInicio,
                    "fim" => $dataFim
                ],
                "total_geral" => $totalGeral,
                "gastos_por_categoria" => $gastosPorCategoria
            ]
        ];
    }

    
   private function validarDadosDespesa(string $descricao, float|null $valor, string $categoria, string $data): array {
        if (empty($descricao)) {
            return ["valido" => false, "mensagem" => "Descrição deve ter pelo menos 3 caracteres"];
        }

        if ($valor === null || $valor === false) {
            return ["valido" => false, "mensagem" => "Valor deve ser informado"];
        }

        if ($valor <= 0) {
            return ["valido" => false, "mensagem" => "Valor deve ser maior que zero"];
        }

        if (empty($categoria)) {
            return ["valido" => false, "mensagem" => "A categoria deve ser informada"];
        }

        if (empty($data)) {
            return ["valido" => false, "mensagem" => "Data inválida"];
        }
        return ["valido" => true];
}
   
    private function validarData(string $data): bool
    {
        $d = \DateTime::createFromFormat("Y-m-d", $data);
        return $d && $d->format("Y-m-d") === $data;
    }

    
    public function getCategorias(): array
    {
        return [
            "alimentacao" => "Alimentação",
            "transporte" => "Transporte",
            "moradia" => "Moradia",
            "saude" => "Saúde",
            "educacao" => "Educação",
            "lazer" => "Lazer",
            "vestuario" => "Vestuário",
            "tecnologia" => "Tecnologia",
            "outros" => "Outros"
        ];
    }
}

?>

