# Company Seeker

Este é um projeto desenvolvido utilizando Laravel com jQuery e Bootstrap.

Algumas das tecnologias (principais) usadas foram:
 - Laravel
 - jQuery
 - Bootstrap

## Requisitos

 - PHP >= 7.4
 - Extensões PHP necessárias para rodar uma aplicação Larvel
 - Extensões adicionais (php.ini) extension=sqlite3 e extension=pdo_sqlite
 - Composer para gerenciamento de pacotes PHP

## Desafios

A parte mais desafiadora, na realidade, foi montar um app bonito e com elementos visuais agradáveis, para passar uma boa impressão aos usuários.

## Configuração do Ambiente Laravel

Para configurar o ambiente de desenvolvimento Laravel, siga o [passo a passo oficial](https://laravel.com/docs/10.x#sail-on-windows).

## .ENV (Variáveis de ambiente)

**Copiar o arquivo .env.example e renomea-lo para .env**

## Comandos

### Baixar dependências

```bash
composer install
```

### Rodar as migrations

```bash
php artisan migrate
```

### Gerar a chave da aplicação

```bash
php artisan key:generate
```

### Ativar link simbólico

```bash
php artisan storage:link
```

### Rodar a aplicação

```bash
php artisan serve
```

## Autor

Gabriel Fernandes Lima
