let carrinho = {}; // Armazena os produtos e suas quantidades no carrinho

document.addEventListener('DOMContentLoaded', () => {
    const produtos = document.querySelectorAll('[id^="quantidade-"]');
    produtos.forEach(function (produto) {
        const produtoId = produto.id.split('-')[1];
        const estoque = parseInt(document.getElementById('estoque-' + produtoId).value) || 0;
        const vendeSemEstoque = document.getElementById('vende-sem-estoque-' + produtoId).value === 'true';
        atualizarBotaoIncremento({ id: produtoId, estoque: estoque, vende_sem_estoque: vendeSemEstoque });
    });

    // Atualizar valor total inicialmente
    atualizarValorTotal();

    // Filtro de busca para os produtos
    document.getElementById('buscar-produto').addEventListener('input', function() {
        const termoBusca = this.value;

        // Fazer uma requisição (AJAX) para buscar os produtos
        fetch(`/pedido/buscar-produtos?nome=${encodeURIComponent(termoBusca)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na requisição');
                }
                return response.json();
            })
            .then(produtos => {
                atualizarProdutosNaTela(produtos);
            })
            .catch(error => {
                console.error('Erro ao buscar produtos:', error);
            });
    });

    // Validação do método de pagamento
    document.getElementById('forma-pagamento').addEventListener('change', function() {
        const metodoPagamentoSelecionado = this.options[this.selectedIndex].text.toLowerCase();
        const pagamentoContainer = document.getElementById('pagamento-container');
        if (metodoPagamentoSelecionado.includes('dinheiro')) {
            pagamentoContainer.style.display = 'block';
        } else {
            pagamentoContainer.style.display = 'none';
        }
    });

    // Cria um elemento para mostrar o valor total na tela
    const totalContainer = document.createElement('div');
    totalContainer.id = 'valor-total';
    totalContainer.className = 'text-center mt-4';
    totalContainer.textContent = 'Valor Total: R$ 0.00';
    document.querySelector('.container').appendChild(totalContainer);

    // Adiciona a seção para pagamento em dinheiro
    const pagamentoContainer = document.createElement('div');
    pagamentoContainer.id = 'pagamento-container';
    pagamentoContainer.className = 'mt-4';
    pagamentoContainer.style.display = 'none';
    pagamentoContainer.innerHTML = `
        <div class="form-group">
            <label for="valor-recebido">Valor Recebido:</label>
            <input type="number" id="valor-recebido" class="form-control" placeholder="Digite o valor recebido...">
        </div>
        <div class="form-group">
            <label for="troco">Troco:</label>
            <input type="text" id="troco" class="form-control" readonly>
        </div>
    `;
    document.querySelector('.container').appendChild(pagamentoContainer);

    document.getElementById('valor-recebido').addEventListener('input', function() {
        const valorRecebido = parseFloat(this.value) || 0;
        const valorTotal = calcularValorTotal();
        const trocoElement = document.getElementById('troco');
        const troco = valorRecebido - valorTotal;
        trocoElement.value = troco >= 0 ? `R$ ${troco.toFixed(2)}` : 'Valor insuficiente';
    });
});

function atualizarBotaoIncremento(produto) {
    const botaoIncrementar = document.querySelector(`#incrementar-${produto.id}`);
    const botaoDecrementar = document.querySelector(`#decrementar-${produto.id}`);
    const inputQuantidade = document.querySelector(`#quantidade-${produto.id}`);

    // Log para mostrar o valor de vende_sem_estoque
    console.log(`Produto ID ${produto.id} - vende_sem_estoque: ${produto.vende_sem_estoque}`);

    // Força a atualização do botão de incremento no carregamento da página
    if (produto.vende_sem_estoque) {
        botaoIncrementar.disabled = false;
    } else {
        botaoIncrementar.disabled = produto.estoque <= 0;
    }

    let quantidadeAtual = carrinho[produto.id] || 0;
    inputQuantidade.value = quantidadeAtual;
    botaoDecrementar.disabled = quantidadeAtual === 0;

    botaoIncrementar.addEventListener('click', () => {
        quantidadeAtual = parseInt(inputQuantidade.value) || 0;
        if (produto.vende_sem_estoque || quantidadeAtual < produto.estoque) {
            quantidadeAtual++;
            inputQuantidade.value = quantidadeAtual;
            botaoDecrementar.disabled = false;
            atualizarCarrinho(produto.id, quantidadeAtual);
        }
    });

    botaoDecrementar.addEventListener('click', () => {
        quantidadeAtual = parseInt(inputQuantidade.value) || 0;
        if (quantidadeAtual > 0) {
            quantidadeAtual--;
            inputQuantidade.value = quantidadeAtual;
            botaoDecrementar.disabled = quantidadeAtual === 0;
            atualizarCarrinho(produto.id, quantidadeAtual);
        }
    });
}

function atualizarCarrinho(produtoId, quantidade) {
    if (quantidade > 0) {
        carrinho[produtoId] = quantidade;
    } else {
        delete carrinho[produtoId];
    }
    atualizarValorTotal();
}

function atualizarValorTotal() {
    let total = 0;
    console.log(carrinho);
    for (const produtoId in carrinho) {
        const quantidade = carrinho[produtoId];
        const precoElement = document.getElementById(`preco-${produtoId}`);
        if (precoElement) {
            console.log('aqui');
            const preco = parseFloat(precoElement.value);
            total += quantidade * preco;
        }
    }
    const totalElement = document.getElementById('valor-total');
    if (totalElement) {
        totalElement.textContent = `Valor Total: R$ ${total.toFixed(2)}`;
    }
}

function atualizarProdutosNaTela(produtos) {
    const containerProdutos = document.querySelector('.container .row');
    containerProdutos.innerHTML = '';

    produtos.forEach(produto => {
        const produtoHtml = `
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">${produto.nome}</h5>
                        <p class="card-text">Preço: R$ ${produto.preco_venda}</p>
                        <p class="card-text">Estoque: ${produto.quantidade ?? 0}</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-danger btn-sm" id="decrementar-${produto.id}" type="button">-</button>
                            <input type="text" class="form-control text-center mx-2 w-25" id="quantidade-${produto.id}" value="${carrinho[produto.id] || 0}" readonly>
                            <button class="btn btn-success btn-sm" id="incrementar-${produto.id}" type="button">+</button>
                        </div>
                        <input type="hidden" name="produto_id[]" value="${produto.id}">
                        <input type="hidden" id="estoque-${produto.id}" value="${produto.quantidade ?? 0}">
                        <input type="hidden" id="vende-sem-estoque-${produto.id}" value="${produto.vende_sem_estoque}">
                        <input type="hidden" id="preco-${produto.id}" value="${produto.preco_venda}">
                    </div>
                </div>
            </div>
        `;
        containerProdutos.insertAdjacentHTML('beforeend', produtoHtml);
        atualizarBotaoIncremento(produto);
    });
    atualizarValorTotal(); // Atualizar valor total após renderizar os produtos
}

function calcularValorTotal() {
    let total = 0;
    document.querySelectorAll('[id^="quantidade-"]').forEach(input => {
        const produtoId = input.id.split('-')[1];
        const quantidade = parseInt(input.value);
        const precoElement = document.getElementById(`preco-${produtoId}`);
        if (precoElement) {
            const preco = parseFloat(precoElement.value);
            if (quantidade >= 0) {
                total += quantidade * preco;
            }
        }
    });
    const totalElement = document.getElementById('valor-total');
    if (totalElement) {
        totalElement.textContent = `Valor Total: R$ ${total.toFixed(2)}`;
    }
    return total;
}
