document.addEventListener('DOMContentLoaded', function () {
    const produtoSelecionadoCard = document.getElementById('produto-selecionado-card');
    const produtoSelecionadoImagem = document.getElementById('produto-selecionado-imagem');
    const produtoSelecionadoNome = document.getElementById('produto-selecionado-nome');
    const produtoSelecionadoCodigo = document.getElementById('produto-selecionado-codigo');
    const produtoSelecionadoPreco = document.getElementById('produto-selecionado-preco');

    const selectProduto = document.getElementById('item');

    selectProduto.addEventListener('change', function () {
        const selectedOption = selectProduto.options[selectProduto.selectedIndex];
        const nome = selectedOption.getAttribute('data-nome');
        const preco = selectedOption.getAttribute('data-preco');
        const codigo = selectedOption.getAttribute('data-codigo');
        const imagem = selectedOption.getAttribute('data-imagem');

        // Atualiza o card com os dados do produto selecionado
        produtoSelecionadoNome.textContent = nome;
        produtoSelecionadoCodigo.textContent = codigo;
        produtoSelecionadoPreco.textContent = preco;
        produtoSelecionadoImagem.src = imagem || 'https://via.placeholder.com/100';

        // Exibe o card
        produtoSelecionadoCard.style.display = 'block';
    });
});
