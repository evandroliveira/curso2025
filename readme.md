Este projeto é um sistema web de controle de estoque, cadastro de clientes, fornecedores e usuários, desenvolvido em PHP com banco de dados MySQL e interface usando Bootstrap.

Estrutura dos arquivos principais
index.php: Página inicial, mostra um resumo dos produtos e gráficos.
login.php: Tela de login dos usuários.
cadastro.php: Cadastro de novos usuários.
adicionar_produto.php: Formulário para adicionar produtos.
produtos.php: Lista todos os produtos cadastrados.
editar_produto.php: Permite editar um produto existente.
excluir_produto.php: Exclui um produto.
estoque.php: Lista produtos com estoque baixo.
cad_cliente.php: Cadastro de clientes.
cad_fornecedor.php: Cadastro de fornecedores.
config.php: Configuração da conexão com o banco de dados.
css/: Arquivos de estilos (Bootstrap).
js/: Scripts JavaScript (Bootstrap).
imagens/: Imagens usadas no sistema.
Como executar o projeto
Instale o XAMPP ou similar para rodar Apache e MySQL localmente.
Coloque a pasta do projeto (por exemplo, curso2025) dentro do diretório htdocs do XAMPP.
Crie o banco de dados MySQL chamado avaliacao e as tabelas necessárias (produtos, usuarios, clientes, etc). O script de criação não está incluso aqui, mas é necessário.
Ajuste as configurações de acesso ao banco em config.php se necessário.
Inicie o Apache e o MySQL pelo painel do XAMPP.
Acesse no navegador:
Cadastre um usuário em cadastro.php e faça login para acessar o sistema.
Se precisar de scripts SQL para criar as tabelas, consulte a documentação do projeto ou peça ao responsável pelo sistema.