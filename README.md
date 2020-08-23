# User Manager Application

User Manager é uma aplicação de gerenciamento de usuários desenvolvida utilizando Slim Framework 3 e Twig.
O sistema tem funcionalidades de criar um usuário, fazer login, visualizar os usuários cadastrados, editar e deletar o usuário autenticado.

## Instalar Aplicação

Para funcionamento do sistema é necessário PHP (>=7.4) e [Composer](https://getcomposer.org/)

Clone o repositório do git na sua máquina.

Execute o seguinte comando no terminal:
```bash
composer install
```
No diretório /public no terminal, rode o seguinte comando:
```bash
php -S localhost:8080
```

## Funcionalidades Implementadas

* Criação de um usuário
* Login de usuário
* Edição de usuário
* Listagem de usuários
* Logout

## TO DO

* Adicionar um SessionMiddleware para restringir o acesso das urls
* Deletar usuário
* Paginação da listagem
* Deixar erros de validação mais verbosos
* Testes unitários

