# Documentação da API

Bem-vindo! Este repositório contém a API para o sistema de help-desk desenvolvido em Laravel. Aqui você encontrará instruções detalhadas para instalação, configuração e execução do projeto.

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

Acesse a API em [http://localhost:8000](http://localhost:8000).


## Endpoints

Consulte a [documentação Swagger](http://localhost:8000/api/documentation) para visualizar os endpoints disponíveis.

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues.



---

Se precisar de ajuda, entre em contato pelo e-mail: **oliveirarafael22@outlook.com.br**.
