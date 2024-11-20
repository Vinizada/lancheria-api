let carrinho = {};
let valorTotalCarrinho = 0;

document.addEventListener('DOMContentLoaded', () => {
    carregarProdutosIniciais();
    configurarEventos();
});

function carregarProdutosIniciais() {
    const produtos = document.querySelectorAll('[id^="quantidade-"]');
    produtos.forEach(produto => {
        const produtoId = produto.id.split('-')[1];
        const estoque = parseInt(document.getElementById('estoque-' + produtoId)?.value) || 0;
        const preco = parseFloat(document.getElementById('preco-' + produtoId)?.value) || 0;
        const vendeSemEstoque = document.getElementById('vende-sem-estoque-' + produtoId)?.value === 'true';

        if (carrinho[produtoId]) {
            carrinho[produtoId] = { ...carrinho[produtoId], preco }; // Atualiza o preço caso já esteja no carrinho
        }

        atualizarBotaoIncremento({ id: produtoId, estoque, vende_sem_estoque: vendeSemEstoque, preco: preco });
    });
    atualizarValorTotalCarrinho();
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
            event.preventDefault();
            exibirProdutosSelecionados();
        });
    }
}

function verificarHabilitacaoBotao() {
    const enviarPedidoButton = document.getElementById('enviar-pedido');

    if (enviarPedidoButton) {
        enviarPedidoButton.disabled = !(Object.keys(carrinho).length > 0);
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

function buscarMetodosPagamento() {
    return fetch(`/pedido/buscar-pagamentos`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao buscar métodos de pagamento');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erro ao buscar métodos de pagamento:', error);
            return [];
        });
}

function atualizarProdutosNaTela(produtos) {
    const containerProdutos = document.getElementById('produtos-container');
    containerProdutos.innerHTML = '';

    produtos.forEach(produto => {
        const vendeSemEstoque = produto.vende_sem_estoque ? 'true' : 'false';
        const quantidadeAtual = carrinho[produto.id]?.quantidade || 0;

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
            vende_sem_estoque: vendeSemEstoque === 'true',
            preco: produto.preco_venda
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

        let quantidadeAtual = carrinho[produto.id]?.quantidade || 0;
        inputQuantidade.value = quantidadeAtual;
        botaoDecrementar.disabled = quantidadeAtual === 0;

        botaoIncrementar.addEventListener('click', () => {
            quantidadeAtual = parseInt(inputQuantidade.value) || 0;
            if (produto.vende_sem_estoque || quantidadeAtual < produto.estoque) {
                quantidadeAtual++;
                inputQuantidade.value = quantidadeAtual;
                botaoDecrementar.disabled = false;
                atualizarCarrinho(produto.id, quantidadeAtual, produto.preco);
            }
        });

        botaoDecrementar.addEventListener('click', () => {
            quantidadeAtual = parseInt(inputQuantidade.value) || 0;
            if (quantidadeAtual > 0) {
                quantidadeAtual--;
                inputQuantidade.value = quantidadeAtual;
                botaoDecrementar.disabled = quantidadeAtual === 0;
                atualizarCarrinho(produto.id, quantidadeAtual, produto.preco);
            }
        });
    }
}

function atualizarCarrinho(produtoId, quantidade, preco) {
    if (quantidade > 0) {
        carrinho[produtoId] = { quantidade, preco };
    } else {
        delete carrinho[produtoId];
    }
    atualizarValorTotalCarrinho();
    verificarHabilitacaoBotao();
}

function atualizarValorTotalCarrinho() {
    let total = 0;
    for (const produtoId in carrinho) {
        const { quantidade, preco } = carrinho[produtoId];
        total += quantidade * preco;
    }
    valorTotalCarrinho = total;
    const totalElement = document.getElementById('valor-total');
    if (totalElement) {
        totalElement.textContent = `R$ ${valorTotalCarrinho.toFixed(2)}`;
    }
    return valorTotalCarrinho;
}

function exibirProdutosSelecionados() {
    let modal = document.getElementById('modalProdutosSelecionados');
    if (modal) {
        modal.remove();
    }

    modal = document.createElement('div');
    modal.id = 'modalProdutosSelecionados';
    modal.className = 'modal fade';
    modal.tabIndex = '-1';
    modal.role = 'dialog';

    const valorTotal = atualizarValorTotalCarrinho();

    modal.innerHTML = `
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Produtos Selecionados</h5>
                    <button type="button" class="close" onclick="fecharModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="listaProdutosSelecionados">
                            ${Object.keys(carrinho).map(produtoId => {
        const { quantidade, preco } = carrinho[produtoId];
        const totalProduto = (quantidade * preco).toFixed(2);
        return `
                                    <tr>
                                        <td>Produto ID ${produtoId}</td>
                                        <td>${quantidade}</td>
                                        <td>R$ ${preco.toFixed(2)}</td>
                                        <td>R$ ${totalProduto}</td>
                                    </tr>
                                `;
    }).join('')}
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong>Valor Total da Compra:</strong>
                        <span id="valorTotalCompra">R$ ${valorTotal.toFixed(2)}</span>
                    </div>
                    <div class="form-group">
                        <label for="formaPagamentoModal">Forma de Pagamento</label>
                        <select id="formaPagamentoModal" class="form-control">
                            <!-- Métodos de pagamento serão carregados aqui -->
                        </select>
                    </div>
                    <div id="campoTroco" class="form-group" style="display: none;">
                        <label for="valorPago">Valor Pago</label>
                        <input type="number" class="form-control" id="valorPago" placeholder="Digite o valor pago">
                    </div>
                    <div id="campoTrocoResultado" class="form-group" style="display: none;">
                        <label for="troco">Troco</label>
                        <input type="text" class="form-control" id="troco" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fecharModal()">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="prepararFormularioParaEnvio()">Enviar Pedido</button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    $(modal).modal('show');

    // Buscar e preencher os métodos de pagamento
    buscarMetodosPagamento().then(metodos => {
        const formaPagamentoSelect = document.getElementById('formaPagamentoModal');
        if (formaPagamentoSelect) {
            formaPagamentoSelect.innerHTML = metodos.map(metodo => `
                <option value="${metodo.id}">${metodo.metodo}</option>
            `).join('');
        }

        formaPagamentoSelect?.addEventListener('change', function () {
            const campoTroco = document.getElementById('campoTroco');
            const campoTrocoResultado = document.getElementById('campoTrocoResultado');
            if (this.options[this.selectedIndex].text === 'Dinheiro') {
                campoTroco.style.display = 'block';
                campoTrocoResultado.style.display = 'block';
            } else {
                campoTroco.style.display = 'none';
                campoTrocoResultado.style.display = 'none';
            }
        });

        formaPagamentoSelect?.dispatchEvent(new Event('change'));
    });

    document.getElementById('valorPago')?.addEventListener('input', calcularTroco);
}

function calcularTroco() {
    const valorPago = parseFloat(document.getElementById('valorPago').value) || 0;
    const troco = valorPago - valorTotalCarrinho;
    document.getElementById('troco').value = troco >= 0 ? `R$ ${troco.toFixed(2)}` : 'Valor insuficiente';
}

function fecharModal() {
    const modal = document.getElementById('modalProdutosSelecionados');
    if (modal) {
        $(modal).modal('hide');
        modal.addEventListener('hidden.bs.modal', () => {
            modal.remove();
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        });
    }
}

function prepararFormularioParaEnvio() {
    const carrinhoInput = document.getElementById('carrinho-input');
    const formaPagamentoInput = document.getElementById('forma-pagamento-id');
    const valorTotalInput = document.getElementById('valor-total-input');

    if (carrinhoInput && formaPagamentoInput && valorTotalInput) {
        carrinhoInput.value = JSON.stringify(carrinho);
        formaPagamentoInput.value = document.getElementById('formaPagamentoModal')?.value || "";
        valorTotalInput.value = valorTotalCarrinho.toFixed(2);
        document.getElementById('form-pedido').submit();
    }
}
