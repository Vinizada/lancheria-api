document.addEventListener('DOMContentLoaded', function () {

    var homeElement = document.getElementById('elemento-home');

    if (homeElement) {
        document.addEventListener('keydown', function (event) {
            if (event.key === 'v' || event.key === 'V') {
                document.getElementById('link-venda').click();
            }

            if (event.key === 'c' || event.key === 'C') {
                document.getElementById('link-compra').click();
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar os botões de incrementar e decrementar
    const produtos = document.querySelectorAll('[id^="quantidade-"]');

    produtos.forEach(function (produto) {
        const produtoId = produto.id.split('-')[1];  // Extrai o ID do produto a partir do id do input
        const estoque = document.getElementById('estoque-' + produtoId).value;  // Pega a quantidade em estoque
        const btnIncrementar = document.getElementById('incrementar-' + produtoId);
        const btnDecrementar = document.getElementById('decrementar-' + produtoId);

        // Desabilitar o botão de incrementar se não houver estoque
        if (parseInt(estoque) === 0 || estoque === null) {
            btnIncrementar.disabled = true;
        }
    });
});

function incrementar(produtoId) {
    let quantidadeInput = document.getElementById('quantidade-' + produtoId);
    let quantidadeAtual = parseInt(quantidadeInput.value);
    let estoque = parseInt(document.getElementById('estoque-' + produtoId).value);

    if (quantidadeAtual < estoque) {
        quantidadeInput.value = quantidadeAtual + 1;

        // Habilitar o botão de decrementar caso a quantidade seja maior que 0
        document.getElementById('decrementar-' + produtoId).disabled = false;
    }

    // Desabilitar o botão de incrementar se a quantidade atingir o estoque
    if (quantidadeAtual + 1 >= estoque) {
        document.getElementById('incrementar-' + produtoId).disabled = true;
    }
}

function decrementar(produtoId) {
    let quantidadeInput = document.getElementById('quantidade-' + produtoId);
    let quantidadeAtual = parseInt(quantidadeInput.value);

    if (quantidadeAtual > 0) {
        quantidadeInput.value = quantidadeAtual - 1;

        // Desabilitar o botão de incrementar se a quantidade estiver abaixo do estoque
        document.getElementById('incrementar-' + produtoId).disabled = false;
    }

    // Desabilitar o botão de decrementar se a quantidade for 0
    if (quantidadeAtual - 1 === 0) {
        document.getElementById('decrementar-' + produtoId).disabled = true;
    }
}
