/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/home.js ***!
  \******************************/
function atualizarIndicadores() {
  fetch('/home/indicadores').then(function (response) {
    return response.json();
  }).then(function (data) {
    document.getElementById('total-vendas').innerText = "R$ ".concat(data.total_vendas);
    document.getElementById('lucro-percentual').innerText = "".concat(data.lucro_percentual, "%");
    document.getElementById('lucro-valor').innerText = "R$ ".concat(data.lucro_valor);
    document.getElementById('pendente-pagamento').innerText = "R$ ".concat(data.pendente_pagamento);
  })["catch"](function (error) {
    return console.error('Erro ao atualizar indicadores:', error);
  });
}
setInterval(atualizarIndicadores, 30000);
function redirecionarParaPedido(clienteId) {
  if (clienteId) {
    window.location.href = "/pedido/".concat(clienteId);
  } else {
    alert('Por favor, selecione um cliente antes de continuar.');
  }
}
function filtrarClientes() {
  var input = document.getElementById('buscar-cliente').value.toLowerCase();
  var clientes = document.querySelectorAll('.cliente-item');
  clientes.forEach(function (cliente) {
    var nome = cliente.getAttribute('data-nome');
    cliente.style.display = nome.includes(input) ? '' : 'none';
  });
}
document.addEventListener('DOMContentLoaded', function () {
  atualizarIndicadores();
  document.querySelectorAll('.cliente-item').forEach(function (item) {
    item.addEventListener('click', function () {
      var clienteId = item.getAttribute('data-cliente-id');
      redirecionarParaPedido(clienteId);
    });
  });
});
/******/ })()
;