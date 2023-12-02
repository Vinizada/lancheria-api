# lancheria-api
Projeto criado para gerenciar a cafeteria dos meus pais

Esquema de tabelas (TODO criar diagrama)

tabelas:

colaboradores

id unique
nome
email
perfil_id foreign key perfil id
senha
ativo
data_criacao
data_alteracao

perfil

id unique
perfil
ativo
acesso_id foreign key acessos id
data_criacao
data_alteracao

acessos

id unique
acesso
data_criacao
data_alteracao

clientes

id unique
nome
email
celular
limite_credito
ativo
data_criacao
data_alteracao

cliente_pagamento

cliente_id foreign key clientes id
metodo_id foreign key metodos_pagamento id

metodos_pagamento

id unique
metodo
ativo
limite_metodo
data_criacao
data_alteracao

fornecedores

id unique
nome
email
contato
cnpj
ativo
cidade
data_criacao
data_alteracao

produtos

id unique
nome
preco
fornecedor_id
ativo
estoque_minimo
giro_medio
data_criacao
data_alteracao

estoque

produto_id
quantidade
data_validade

movimentacoes

produto_id
pedido_id
cliente_id
quantidade
preco
data
tipo_movimentacao (E entrada S saida)

pedidos

id unique
cliente_id
metodo_id
valor_total
status
data
colaborador_id
cancelado
data_cancelamento
quantidade_itens

itens_pedido

pedido_id
produto_id
quantidade
preco_unitario
preco_total
