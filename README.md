# Back-end Challenge - Onfly 20231205

Projeto desenvolvido como teste técnico no processo seletivo da Onfly. O projeto consiste em criar uma API REST com Laravel, utilizando de CRUD para despesas e controle de acesso das mesmas.

>  This is a challenge by [Coodesh](https://coodesh.com/)

### Tecnologias utilizadas
- Laravel 10
- PHP
- Docker

---

### Como rodar o projeto
- Pré-requisito: ter Docker instalado, composer instalado
- Clone o projeto do github
- Rode comando `composer install`
- Rode o comando: `./vendor/bin/sail up` (para subir a aplicação)
- Rode o comando: `./vendor/bin/sail artisan test` (para rodar os testes)
- Para ver o email: configure o .env
- Para acessar a rota login é necessário informar: email, password e device_name

- Usuários criados:
  1. Maria
     + email: maria@example.com
     + senha: password
  3. João
     + email: joao@example.com
     + senha: password

---

### Processo de investigação para o desenvolvimento

- Tomei a decisão de criar o projeto laravel com o docker, pois facilita a execução em ambientes diferentes
- Primeiro passo é criar as entidades
- Decicir quais estruturas eram necessárias criar para Despesas e para Usuários (controller, model, migrations, etc)
- Configurar CRUD Despesa
- Criar uma Rule personalizada para verificar se a data está no futuro
- Tomei a decisão de não colocar o id do usuário no Request e sim garantir que o id na despesa é o do usuário autenticado
- Me questionei sobre utilizar SoftDelete na model Despesa e optei por seguir sem
- Testei autenticação
- Criei o email
- Criei os testes
- Ajustei o readme
