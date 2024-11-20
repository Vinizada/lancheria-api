function atualizarIndicadores() {
    fetch('/home/indicadores')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-vendas').innerText = `R$ ${data.total_vendas}`;
            document.getElementById('lucro-percentual').innerText = `${data.lucro_percentual}%`;
            document.getElementById('lucro-valor').innerText = `R$ ${data.lucro_valor}`;
            document.getElementById('pendente-pagamento').innerText = `R$ ${data.pendente_pagamento}`;
        })
        .catch(error => console.error('Erro ao atualizar indicadores:', error));
}

setInterval(atualizarIndicadores, 30000);

function redirecionarParaPedido(clienteId) {
    if (clienteId) {
        window.location.href = `/pedido/${clienteId}`;
    } else {
        alert('Por favor, selecione um cliente antes de continuar.');
    }
}

function filtrarClientes() {
    const input = document.getElementById('buscar-cliente').value.toLowerCase();
    const clientes = document.querySelectorAll('.cliente-item');

    clientes.forEach(cliente => {
        const nome = cliente.getAttribute('data-nome');
        cliente.style.display = nome.includes(input) ? '' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    atualizarIndicadores();

    document.querySelectorAll('.cliente-item').forEach(item => {
        item.addEventListener('click', () => {
            const clienteId = item.getAttribute('data-cliente-id');
            redirecionarParaPedido(clienteId);
        });
    });
});
