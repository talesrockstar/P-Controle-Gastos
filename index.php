<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Stylesheet" href="templates/css/style.css">
    <title>Lista de Compras</title>
</head>
<body>
    <header class="Cabecalho">
            <h1>Lista de Compras</h1>
    </header>
        <div class="usuario usuario1">

        <h2>usuario 1:</h2>

    <section>
        <h3>Alimento</h3>
        <div class="adicionar item">
            <label for="input-alimento-usuario1">Novo Item:</label>
            <input id="input-alimento-usuario1" class="input-alimento-usuario1" type="text">
            <button onClick = "adicionarItem('usuario1', 'alimento')">Adicionar</button>
        </div>
        <ul class="lista-alimento-usuario1">
            <li>Arroz</li>
            <li>Feijão</li>
            <li>Macarrão</li>
            <li>Café</li>
            <li>Leite</li>
            <li>Nescau</li>
            <li>Carne</li>
            <li>Ovo</li>
        </ul>

        <h3>Limpeza</h3>
         <div class="adicionar item">
            <label for="input-limpeza-usuario1">Novo Item:</label>
            <input id="input-limpeza-usuario1" class="input-limpeza-usuario1" type="text">
            <button onClick = "adicionarItem('usuario1', 'limpeza')">Adicionar</button>
        </div>
        <ul class="lista-limpeza-usuario1">
            <li>Detergente</li>
            <li>Desinfetante</li>
            <li>Água Sanitária</li>
            <li>Sabão em pó</li>
            <li>Álcool</li>
            <li>Limpador Multiuso</li>
        </ul>

        <h3>Lazer</h3>
         <div class="adicionar item">
            <label for="input-lazer-usuario1">Novo Item:</label>
            <input id="input-lazer-usuario1" class="input-lazer-usuario1" type="text">
            <button onClick = "adicionarItem('usuario1', 'lazer')">Adicionar</button>
        </div>
        <ul class="lista-lazer-usuario1">
            <li>piscina de plastico</li>
            <li>Churrasqueira</li>
            <li>lustres</li>
            <li>Pratos</li>
            <li>Talheres</li>
            <li>Panela</li>
        </ul>

        <h3>Roupas</h3>
         <div class="adicionar item">
            <label for="input-roupas-usuario1">Novo Item:</label>
            <input id="input-roupas-usuario1" class="input-roupas-usuario1" type="text">
            <button onClick = "adicionarItem('usuario1', 'roupas')">Adicionar</button>
        </div>
        <ul class="lista-roupas-usuario1">
            <li>Camisa</li>
            <li>Bermuda</li>
            <li>Calça</li>
            <li>Camiseta</li>
        </ul>
        
        <h3>Casa</h3>
         <div class="adicionar item">
            <label for="input-Casa-usuario1">Novo Item:</label>
            <input id="input-casa-usuario1" class="input-casa-usuario1" type="text">
            <button onClick = "adicionarItem('usuario1', 'casa')">Adicionar</button>
        </div>
        <ul class="lista-casa-usuario1">
            <li>Lampada</li>
            <li>Facas</li>
            <li>Coberta</li>
            <li>Geladeira</li>
        </ul>
    </section>
    </div>
    </div>

    <div class="usuario usuario2">
        <h2>usuario 2</h2>
    
    <section>
        <h3>Alimento</h3>
         <div class="adicionar item">
            <label for="input-alimento-usuario2">Novo Item:</label>
            <input id="input-alimento-usuario2" class="input-alimento-usuario2" type="text">
            <button onClick = "adicionarItem('usuario2', 'alimento')">Adicionar</button>
        </div>
        <ul class="lista-alimento-usuario2">
            <li>Presunto</li>
            <li>Queijo</li>
            <li>Pão</li>
            <li>Sopa</li>
            <li>Salsicha</li>
            <li>Mortadela</li>
            <li>Café</li>
            <li>Danone</li>
        </ul>

        <h3>Limpeza</h3>
        <div class="adicionar item">
            <label for="input-lazer-usuario2">Novo Item:</label>
            <input id="input-lazer-usuario2" class="input-lazer-usuario2" type="text">
            <button onClick = "adicionarItem('usuario2', 'lazer')">Adicionar</button>
        </div>
         <ul class="lista-lazer-usuario2">
            <li>Conjunto de panelas</li>
            <li>liquidificador</li>
            <li>Batedeira</li>
            <li>Conjunto de churrasco</li>
            <li>Copos</li>
            <li>Tauba</li>
        </ul>

        <h3>Frutas</h3>
        <div class="adicionar item">
            <label for="input-frutas-usuario2">Novo Item:</label>
            <input id="input-frutas-usuario2" class="input-frutas-usuario2" type="text">
            <button onClick = "adicionarItem('usuario2', 'frutas')">Adicionar</button>
        </div>
        <ul class="lista-frutas-usuario2">
            <li>Abacaxi</li>
            <li>Melancia</li>
            <li>Kiwi</li>
            <li>Manga</li>
            <li>Mamão</li>
            <li>Amora</li>
            <li>Framboesa</li>
        </ul>

        <h3>Roupas</h3>
        <div class="adicionar item">
            <label for="input-roupas-usuario2">Novo Item:</label>
            <input id="input-raupas-usuario2" class="input-roupas-usuario2" type="text">
            <button onClick = "adicionarItem('usuario2', 'roupas')">Adicionar</button>
        </div>
        <ul class="lista-roupas-usuario2">
            <li>Short</li>
            <li>Calça</li>
            <li>Blusa</li>
            <li>Meia-calça</li>
            <li>Top</li>
        </ul>

        <h3>Casa</h3>
        <div class="adicionar item">
            <label for="input-casa-usuario2">Novo Item:</label>
            <input id="input-casa-usuario2" class="input-casa-usuario2" type="text">
            <button onClick = "adicionarItem('usuario2', 'casa')">Adicionar</button>
        </div>
        <ul class="lista-casa-usuario2">
            <li>Televisão</li>
            <li>Vaso</li>
            <li>Traviseiro</li>
            <li>Computador</li>
            <li>Quadro</li>
            <li>Jogo americano</li>
            <li>Xicaras</li>
        </ul>
    </section>
    </div>

    <button onclick="excluirItens()">Excluir Intens da Lista</button>
    <button onclick="adicionarItens()">Adicionar Item</button>

    </div>
    <Script src="script.js"></Script>
</body>
</html>