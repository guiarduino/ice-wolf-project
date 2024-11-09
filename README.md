# API slim PHP [Ice-Wolf]

Este projeto é um starter-pack para se iniciar um projeto API com PHP slim.<br>
Seu objetivo é facilitar a criação dos metodos para se criar uma aplicação REST.<br>
Também disponibiliza alguns comandos para criação e atualização de banco de dados (Migrate).<br>

## Tecnologias Utilizadas

- **PHP**: A principal linguagem de programação deste projeto, sendo utilizada para toda a lógica de backend. Através do PHP, o projeto oferece flexibilidade, performance e facilidade de integração com bancos de dados e serviços externos. A versão em uso é a **PHP 8.0**.  
- **Slim Framework**: Framework PHP minimalista utilizado para criar rotas RESTful e facilitar a construção da aplicação. O Slim oferece um conjunto simples de ferramentas para gerenciar rotas HTTP, middlewares e injeção de dependências, proporcionando uma experiência de desenvolvimento ágil e leve.

## Funcionalidades

- Comando para facilitar a criação das classes Model, DAO e Controller. (todo)
- Metodos REST basicos já prontos para usar (GET, POST, PUT, DELETE).
- Comando para mostrar as rotas validas no sistema.
- Comando para criação e execução de migrations. (todo)

## Instalação

Siga os passos abaixo para rodar o projeto localmente:

1. Clone o repositório:
    ```bash
    git clone https://github.com/guiarduino/ice-wolf-project

2. Navegue até o diretório do projeto:
    ```bash
    cd ice-wolf-project

3. Instale as dependências:
    ```bash
    composer install

4. Configure o arquivo env.php
    - Copie o arquivo "exepleenv.php" na raiz do projeto e renomeie para "env.php" e preencha os dados com as informações do seu baco de dados.
        - putenv('DB_MYSQL_HOST={ip_da_maquina_do_banco_de_dados}');
        - putenv('DB_MYSQL_PORT={nome_do_usuario_do_banco_de_dados}');
        - putenv('DB_MYSQL_USER={nome_do_usuario_do_banco_de_dados}');
        - putenv('DB_MYSQL_PASSWORD={senha_do_usuario}');
        - putenv('DB_MYSQL_DBNAME={nome_da_base_de_dados}');

5. Inicie o servidor de desenvolvimento:
    ```bash
    php -S localhost:8000

6. Acesse a pagina:
    - Abra seu navegador e acesse o link http://localhost:8000/

## Comandos Uteis

1. Comando para mosrtar as rotas do projeto
    ```bash
    composer show:routes

## Contato

Se você tiver alguma dúvida ou sugestão, pode me contatar em guibarlatti@gmail.com<br>
Obrigado por visitar meu projeto!