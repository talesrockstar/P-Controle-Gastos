<?php

//Define o tipo de conteúdo da resposta
header('Content-Type: application/json');

class UsuarioHalder {
    private string $arquivo;

    public function __construct(string $arquivo) {
        $this->arquivo = $arquivo;
    }

    public function salvar(array $dados): array {
        //Salva os dados no arquivo em formato JSON formatado
        $sucesso = file_put_contents(
            $this->arquivo,
            json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        if($sucesso === false) {
            return(["status" => "erro", "mensagem" => "Falha a salvar os dados."]);
        }
            return(["status" => "ok", "mensagem" => "Os dados foram recebidos com sucesso!"]);
    }
}

//Recebe o Json enviado pelo javaScript
$dadosJSON = file_get_contents('php://input');
//Converte o Json para um array PHP
$dados = json_decode($dadosJSON, true);

//Verifica se a conversão foi bem sucedida!
if($dados === null) {
    http_response_code(400);
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao processar os dados."]);
    exit;
}

//Execução
$handler = new UsuarioHandler("Lista_usuarios.json");
$resposta = $handler->salvar($dados);
echo json_encode($resposta);

?>