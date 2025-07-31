<script>
    
// Adiciona novo item à lista
function adicionarItem(usuario, categoria) {
    const inputId = `input-${categoria}-${usuario}`;
    const listaClasse = `lista-${categoria}-${usuario}`;

    const input = document.getElementById(inputId);
    const valor = input.value.trim();

    if (valor !== "") {
        const ul = document.querySelector(`.${listaClasse}`);
        const li = document.createElement("li");
        li.textContent = valor;
        adicionarEventoMarcaComprado(li); // Aplica o evento
        ul.appendChild(li);

        const dados = {
            usuario: usuario,
            categoria: categoria,
            item: valor
        };

        fetch("adicionar_item.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dados)
        })
        .then(res => res.json())
        .then(resposta => {
            if (resposta.status === "ok") {
                console.log("Item salvo no banco!");
            } else {
                console.warn("Erro ao salvar:", resposta.mensagem);
            }
        })
        .catch(erro => console.error("Erro ao enviar item:", erro));
    }
}

// Marca/desmarca itens como comprados
function adicionarEventoMarcaComprado(li) {
    li.addEventListener('click', () => {
        li.classList.toggle('comprado');
    });
}

// Aplica o evento a todos os itens existentes ao carregar a página
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll("ul li").forEach(adicionarEventoMarcaComprado);
});

// Limpa todas as listas
function excluirItens() {
    const listas = document.querySelectorAll("ul");
    listas.forEach(ul => {
        ul.innerHTML = "";
    });
}

// Coleta dados e envia para user.php
function adicionarItens() {
    const usuarios = ["usuario1", "usuario2"];
    const categorias = ["alimento", "limpeza", "frutas", "legumes", "hortaliças"];

    const dados = {};

    usuarios.forEach(usuario => {
        dados[usuario] = {};
        categorias.forEach(categoria => {
            const listaClasse = `.lista-${categoria}-${usuario}`;
            const itens = [];
            document.querySelectorAll(`${listaClasse} li`).forEach(li => {
                itens.push(li.textContent);
            });
            dados[usuario][categoria] = itens;
        });
    });

    fetch("user.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.text())
    .then(data => {
        alert("Itens enviados com sucesso!");
        console.log("Resposta do PHP:", data);
    })
    .catch(error => {
        alert("Erro ao enviar os dados.");
        console.error("Erro:", error);
    });
}

</script>