let carrinho = {}; // Armazena os produtos e suas quantidades no carrinho
let valorTotalCarrinho = 0; // Variável global para manter o valor total do carrinho

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
    atualizarValorTotalCarrinho(); // Atualiza o valor total ao carregar os produtos
    verificarHabilitacaoBotao();
}

function configurarEventos() {
    const buscarProdutoInput = document.getElementById('buscar-produto');
    const formaPagamentoSelect = document.getElementById('forma-pagamento');
    const enviarPedidoButton = document.getElementById('enviar-pedido');

    if (buscarProdutoInput) {
        buscarProdutoInput.addEventListener('input', function () {
            const termoBusca = this.value.trim();
            buscarProdutos(termoBusca);
        });
    }

    if (formaPagamentoSelect) {
        formaPagamentoSelect.addEventListener('change', function () {
            verificarHabilitacaoBotao();
        });
    }

    if (enviarPedidoButton) {
        enviarPedidoButton.addEventListener('click', function (event) {
            const formaPagamento = formaPagamentoSelect.selectedOptions[0]?.text || '';
            if (formaPagamento === 'Dinheiro') {
                event.preventDefault();
                exibirModalTroco();
            } else {
                prepararFormularioParaEnvio(document.getElementById('form-pedido'));
            }
        });
    }
}

function verificarHabilitacaoBotao() {
    const formaPagamentoSelect = document.getElementById('forma-pagamento');
    const enviarPedidoButton = document.getElementById('enviar-pedido');

    if (enviarPedidoButton) {
        enviarPedidoButton.disabled = !(formaPagamentoSelect.value !== "" && Object.keys(carrinho).length > 0);
    }
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

function atualizarProdutosNaTela(produtos) {
    const containerProdutos = document.getElementById('produtos-container');
    containerProdutos.innerHTML = '';

    produtos.forEach(produto => {
        const vendeSemEstoque = produto.vende_sem_estoque ? 'true' : 'false';
        const quantidadeAtual = carrinho[produto.id] || 0; // Mantém a quantidade do carrinho se já existir

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
                            <input type="text" class="form-control text-center mx-2 w-25" id="quantidade-${produto.id}" value="${quantidadeAtual}" readonly>
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

    verificarHabilitacaoBotao();
}

function atualizarBotaoIncremento(produto) {
    const botaoIncrementar = document.querySelector(`#incrementar-${produto.id}`);
    const botaoDecrementar = document.querySelector(`#decrementar-${produto.id}`);
    const inputQuantidade = document.querySelector(`#quantidade-${produto.id}`);

    if (botaoIncrementar && botaoDecrementar && inputQuantidade) {
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
}

function atualizarCarrinho(produtoId, quantidade) {
    if (quantidade > 0) {
        carrinho[produtoId] = quantidade;
    } else {
        delete carrinho[produtoId];
    }
    atualizarValorTotalCarrinho(); // Atualiza o valor total do carrinho
    verificarHabilitacaoBotao();
}

function atualizarValorTotalCarrinho() {
    let total = 0;
    for (const produtoId in carrinho) {
        const quantidade = carrinho[produtoId];
        const precoElement = document.getElementById(`preco-${produtoId}`);
        if (precoElement) {
            const preco = parseFloat(precoElement.value);
            total += quantidade * preco;
        }
    }
    valorTotalCarrinho = total; // Atualiza a variável global
    const totalElement = document.getElementById('valor-total');
    if (totalElement) {
        totalElement.textContent = `R$ ${valorTotalCarrinho.toFixed(2)}`;
    }
    return valorTotalCarrinho;
}

function exibirModalTroco() {
    const totalPedido = atualizarValorTotalCarrinho();
    const modalHtml = `
        <div class="modal" id="modalTroco" tabindex="-1" role="dialog" aria-labelledby="modalTrocoLabel" style="display: block; background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTrocoLabel">Calculadora de Troco</h5>
                        <button type="button" class="close" onclick="fecharModal()" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="valor-recebido">Valor Recebido:</label>
                            <input type="number" class="form-control" id="valor-recebido" placeholder="Digite o valor recebido">
                        </div>
                        <div class="form-group">
                            <label>Troco:</label>
                            <p id="troco" class="font-weight-bold">R$ 0,00</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="fecharModal()">Cancelar</button>
                        <button type="button" id="salvar-pedido" class="btn btn-primary">Salvar Pedido</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);

    document.getElementById('valor-recebido').addEventListener('input', function() {
        const valorRecebido = parseFloat(this.value);
        const troco = valorRecebido - totalPedido;

        document.getElementById('troco').textContent = troco >= 0 ? `R$ ${troco.toFixed(2)}` : 'Valor insuficiente';
    });

    document.getElementById('salvar-pedido').addEventListener('click', function() {
        fecharModal(); // Fechar modal ao salvar o pedido
        document.getElementById('form-pedido').submit();
    });
}

function fecharModal() {
    const modal = document.getElementById('modalTroco');
    if (modal) {
        modal.remove();
    }
}
