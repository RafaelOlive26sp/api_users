# Documentação da API

Esta API é utilizada para gerenciar um sistema de acessos em geral, oferecendo funcionalidades para autenticação de usuários, gerenciamento de contas, e administração de privilégios. Ela suporta três níveis de acesso: Administrador, 

Atendente e Cliente.

    Administradores podem acessar e modificar dados de qualquer usuário.
    Atendentes podem gerenciar contas, como update, deletar usuarios e ver uma lista completa de dados de cada usuario e acessar algumas funcionalidades restritas.
    Clientes têm acesso limitado às suas próprias contas.

Autenticação

    A API utiliza autenticação baseada em tokens (Bearer Token via Sanctum). Todos os endpoints que requerem autenticação estão devidamente marcados com a configuração de segurança. O objetivo principal desta documentação é ajudar desenvolvedores a integrar suas aplicações com o sistema, fornecendo detalhes sobre requisições, respostas, e exemplos práticos de uso.
    O Laravel Sanctum é um sistema de autenticação leve que permite gerenciar autenticação via tokens para APIs. Ele suporta autenticação baseada em SPA (Single Page Applications),

Middleware

    A API utiliza o middleware throttle para limitar a quantidade de requisições em determinados endpoints.

Principais funcionalidades:

    Registro, login e logout de usuários.
    Gestão de privilégios para controle de acesso.
    Operações CRUD em usuários (somente admins e atendentes).

Futuras Atualizações:

    Verificação da conta atraves do e-mail.


## Requisitos

Antes de começar, certifique-se de que você tenha as seguintes ferramentas instaladas:

- [PHP](https://www.php.net/) >= 8.1
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) ou outro banco de dados compatível
- [Git](https://git-scm.com/)

## Instalação

Siga os passos abaixo para configurar o ambiente:

### 1. Clonar o Repositório

```bash
git clone https://github.com/RafaelOlive26sp/api_users.git
cd seu-repositorio
```

### 2. Instalar Dependências do PHP

Execute o comando abaixo para instalar as dependências do Laravel:

```bash
composer install
```

### 3. Configurar o Ambiente

Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente:

```bash
cp .env.example .env
```

Edite o arquivo `.env` para incluir as configurações corretas, como conexão com o banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Gerar a Chave da Aplicação

```bash
php artisan key:generate
```

### 5. Executar as Migrações e Seeders

Execute as migrações para criar as tabelas no banco de dados e popular com dados iniciais, se aplicável:

```bash
php artisan migrate --seed
```

### 6. Configurar o Sanctum

Publique as configurações do Sanctum (se ainda não foi feito):

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```


## Executando o Servidor Local

Para iniciar o servidor local, utilize o comando:

```bash
php artisan serve
```

Acesse a API em [https://api-users-rafael.up.railway.app/api/documentation#/](https://api-users-rafael.up.railway.app/api/documentation#/).


## Endpoints

Consulte a [documentação Swagger](https://api-users-rafael.up.railway.app/api/documentation#/) para visualizar os endpoints disponíveis.

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues.



---

Se precisar de ajuda, entre em contato pelo e-mail: **oliveirarafael22@outlook.com.br**.
