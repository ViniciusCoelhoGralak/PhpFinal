# PROJETO FINAL DE PHP

PROJETO FINAL DE PHP - SISTEMA DE GERENCIAMENTO DE VEÍCULOS
=====================================================

1. TEMA ESCOLHIDO
-----------------
O tema escolhido para este projeto é um **Sistema de Gerenciamento de Veículos**. Ele permite que usuários cadastrem, visualizem, editem e excluam veículos associados à sua conta.

2. RESUMO DO FUNCIONAMENTO
--------------------------
Este é um sistema web básico desenvolvido em PHP com MySQL para gerenciar veículos.
As principais funcionalidades são:
-   **Cadastro de Usuário:** Novos usuários podem se registrar no sistema informando um login, e-mail e senha. O sistema verifica a unicidade do login e do e-mail.
-   **Login e Autenticação:** Usuários cadastrados podem fazer login para acessar a área restrita(dashboard). As senhas são armazenadas com hash para segurança.
-   **Dashboard:** Após o login, o usuário é direcionado para um dashboard onde pode:
    -   Cadastrar novos veículos, associando-os à sua conta.
    -   Visualizar uma lista de todos os veículos que cadastrou.
    -   Editar informações de veículos existentes.
    -   Excluir veículos.
-   **Controle de Acesso:** Páginas da área restrita(dashboard) são protegidas e só podem ser acessadas por usuários autenticados.
-   **Validação de Dados:** Todos os formulários possuem validação de campos obrigatórios (front-end via HTML `required` e back-end via PHP).
-   **Logout:** O usuário pode encerrar sua sessão a qualquer momento.
-   **Estética:** O sistema utiliza Bootstrap para uma apresentação visual responsiva e agradável.

3. USUÁRIO E SENHA DE TESTE
---------------------------
Para facilitar a avaliação e teste do sistema, um usuário de teste foi pré-cadastrado no script de criação do banco de dados:

-   **Login:** `teste`
-   **Senha:** `123456`
-   **E-mail:** `teste@teste.com`

Você pode utilizar estas credenciais para acessar a o dashboard após a instalação do banco de dados.

4. PASSOS PARA INSTALAÇÃO E EXECUÇÃO DO BANCO DE DADOS
------------------------------------------------------
Este sistema utiliza o banco de dados MySQL. Siga os passos abaixo para configurar o banco:

**Pré-requisitos:**
-   Servidor web com PHP (preferencialmente XAMPP ou similar)
-   Servidor MySQL (geralmente incluído no XAMPP)
-   PhpMyAdmin (ou outro cliente MySQL de sua preferência)

**Passos:**

a.  **Inicie o Apache e o MySQL:** Certifique-se de que os serviços do Apache e do MySQL estão rodando no painel de controle do seu XAMPP.

b.  **Acesse o PhpMyAdmin:** Abra seu navegador e vá para `http://localhost/phpmyadmin`.

c.  **Importe o Banco de Dados:**
    1.  No PhpMyAdmin, no menu lateral esquerdo, clique na aba **"SQL"** ou **"Importar"** (dependendo da versão).
    2.  Selecione a opção para **"Importar"** (geralmente há um botão "Escolher arquivo" ou "Importar").
    3.  Clique em **"Escolher arquivo"** e navegue até a pasta do seu projeto (`C:\xampp\htdocs\SeuProjeto\sql\`) e selecione o arquivo `criar_banco.sql`.
    4.  Mantenha as opções padrão para o tipo de arquivo.
    5.  Clique em **"Executar"** (ou "Go").

    *Alternativamente, você pode copiar o conteúdo do `criar_banco.sql` e colá-lo diretamente na aba SQL do PhpMyAdmin, executando-o.*

d.  **Verifique a Criação:** Após a execução bem-sucedida, o banco de dados `bd_veiculos` e as tabelas `usuarios` e `veiculos` serão criados, e o usuário de teste (`login: teste`, `senha: 123456`) será inserido.

5. ACESSO AO SISTEMA
--------------------
Após configurar o banco de dados, você pode acessar o sistema no seu navegador através do endereço:
`http://localhost/SeuProjeto/index.php` (Substitua `SeuProjeto` pelo nome real da pasta do seu projeto em `htdocs`).

---
```
