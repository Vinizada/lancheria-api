let carrinho = {}; // Armazena os produtos e suas quantidades no carrinho

document.addEventListener('DOMContentLoaded', () => {
    carregarProdutosIniciais();
    configurarEventos();
});

function carregarProdutosIniciais() {
    const produtos = document.querySelectorAll('[id^="quantidade-"]');
    produtos.forEach(produto => {
        const produtoId = produto.id.split('-')[1];
        const estoque = parseInt(document.getElementById('estoque-' + produtoId).value) || 0;
        const vendeSemEstoque = document.getElementById('vende-sem-estoque-' + produtoId).value === 'true';
        atualizarBotaoIncremento({ id: produtoId, estoque, vende_sem_estoque: vendeSemEstoque });
    });
    atualizarValorTotal();
    verificarHabilitacaoBotao();
}

function configurarEventos() {
    // Filtro de busca para os produtos
    document.getElementById('buscar-produto').addEventListener('input', function () {
        const termoBusca = this.value.trim();
        buscarProdutos(termoBusca);
    });

    // Validação do método de pagamento
    document.getElementById('forma-pagamento').addEventListener('change', function () {
        habilitarProdutos();
    });

    // Evento para o botão de enviar pedido
    document.getElementById('enviar-pedido').addEventListener('click', function (event) {
        event.preventDefault();
        const form = document.getElementById('form-pedido');
        prepararFormularioParaEnvio(form);
    });
}

function buscarProdutos(termoBusca) {
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
}

function verificarHabilitacaoBotao() {
    const pagamentoSelect = document.getElementById('forma-pagamento');
    const enviarPedido = document.getElementById('enviar-pedido');

    enviarPedido.disabled = !(pagamentoSelect.value !== "" && Object.keys(carrinho).length > 0);
}

function prepararFormularioParaEnvio(form) {
    const produtosSelecionados = [];
    for (const produtoId in carrinho) {
        if (carrinho[produtoId] > 0) {
            const quantidade = carrinho[produtoId];
            const preco = parseFloat(document.getElementById(`preco-${produtoId}`).value);
            const estoque = parseInt(document.getElementById(`estoque-${produtoId}`).value);

            produtosSelecionados.push({
                produto_id: produtoId, // Corrigido para 'produto_id'
                quantidade: quantidade,
                preco: preco,
                estoque: estoque
            });
        }
    }

    // Adiciona os produtos selecionados ao formulário como inputs hidden
    form.querySelectorAll('.produto-selecionado').forEach(element => element.remove());
    produtosSelecionados.forEach(produto => {
        const inputQuantidade = document.createElement('input');
        inputQuantidade.type = 'hidden';
        inputQuantidade.name = `produtos[${produto.produto_id}][quantidade]`;
        inputQuantidade.value = produto.quantidade;
        inputQuantidade.classList.add('produto-selecionado');
        form.appendChild(inputQuantidade);

        const inputPreco = document.createElement('input');
        inputPreco.type = 'hidden';
        inputPreco.name = `produtos[${produto.produto_id}][preco]`;
        inputPreco.value = produto.preco;
        inputPreco.classList.add('produto-selecionado');
        form.appendChild(inputPreco);

        const inputEstoque = document.createElement('input');
        inputEstoque.type = 'hidden';
        inputEstoque.name = `produtos[${produto.produto_id}][estoque]`;
        inputEstoque.value = produto.estoque;
        inputEstoque.classList.add('produto-selecionado');
        form.appendChild(inputEstoque);
    });

    // Atualiza o valor total no input hidden com o valor já exibido
    const valorTotal = document.getElementById('valor-total').textContent.replace('R$ ', '').replace(',', '.').trim();
    document.getElementById('valor-total-input').value = parseFloat(valorTotal);

    // Atualiza o ID do método de pagamento
    document.getElementById('forma-pagamento-id').value = document.getElementById('forma-pagamento').value;

    form.submit();
}

function atualizarBotaoIncremento(produto) {
    const botaoIncrementar = document.querySelector(`#incrementar-${produto.id}`);
    const botaoDecrementar = document.querySelector(`#decrementar-${produto.id}`);
    const inputQuantidade = document.querySelector(`#quantidade-${produto.id}`);

    botaoIncrementar.disabled = !produto.vende_sem_estoque && produto.estoque <= 0;

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
    verificarHabilitacaoBotao();
}

function atualizarValorTotal() {
    let total = 0;
    for (const produtoId in carrinho) {
        const quantidade = carrinho[produtoId];
        const precoElement = document.getElementById(`preco-${produtoId}`);
        if (precoElement) {
            const preco = parseFloat(precoElement.value);
            total += quantidade * preco;
        }
    }
    const totalElement = document.getElementById('valor-total');
    if (totalElement) {
        totalElement.textContent = `R$ ${total.toFixed(2)}`;
    }
    return total;
}

function atualizarProdutosNaTela(produtos) {
    const containerProdutos = document.getElementById('produtos-container');
    containerProdutos.innerHTML = '';

    produtos.forEach(produto => {
        const vendeSemEstoque = produto.vende_sem_estoque ? 'true' : 'false';

        const produtoHtml = `
            <div class="col-12">
                <div class="card mb-3 shadow-sm d-flex flex-row align-items-center" style="height: 120px;">
                    <img src="/produto/imagem/${produto.id}" alt="Imagem do Produto" class="img-fluid" style="width: 120px; height: 100%; object-fit: cover;">
                    <div class="card-body d-flex flex-row align-items-center" style="flex: 1;">
                        <div class="info-produto d-flex flex-column justify-content-between mr-3">
                            <h5 class="card-title">${produto.nome}</h5>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-dollar-sign mr-1"></i>
                                <span>${parseFloat(produto.preco_venda).toFixed(2)}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-box mr-1"></i>
                                <span>${produto.quantidade ?? 0}</span>
                            </div>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <button class="btn btn-danger btn-sm" id="decrementar-${produto.id}" type="button">-</button>
                            <input type="text" class="form-control text-center mx-2 w-25" id="quantidade-${produto.id}" value="${carrinho[produto.id] || 0}" readonly>
                            <button class="btn btn-success btn-sm" id="incrementar-${produto.id}" type="button">+</button>
                        </div>
                    </div>
                    <input type="hidden" id="estoque-${produto.id}" value="${produto.quantidade ?? 0}">
                    <input type="hidden" id="vende-sem-estoque-${produto.id}" value="${vendeSemEstoque}">
                    <input type="hidden" id="preco-${produto.id}" value="${produto.preco_venda}">
                </div>
            </div>
        `;
        containerProdutos.insertAdjacentHTML('beforeend', produtoHtml);
        atualizarBotaoIncremento({
            id: produto.id,
            estoque: produto.quantidade,
            vende_sem_estoque: vendeSemEstoque === 'true'
        });
    });

    atualizarValorTotal();
    verificarHabilitacaoBotao();
}

function habilitarProdutos() {
    const pagamentoSelect = document.getElementById('forma-pagamento');
    const buscarProduto = document.getElementById('buscar-produto');
    const enviarPedido = document.getElementById('enviar-pedido');

    if (pagamentoSelect.value !== "") {
        buscarProduto.disabled = false;
        enviarPedido.disabled = false;
        document.querySelectorAll('button[type="button"]').forEach(button => {
            button.disabled = false;
        });
    } else {
        desabilitarProdutos();
    }
}

function desabilitarProdutos() {
    const buscarProduto = document.getElementById('buscar-produto');
    const enviarPedido = document.getElementById('enviar-pedido');

    buscarProduto.disabled = true;
    enviarPedido.disabled = true;
    document.querySelectorAll('button[type="button"]').forEach(button => {
        button.disabled = true;
    });
}
