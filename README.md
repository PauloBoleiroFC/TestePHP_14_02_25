

## Teste para desenvolvedor PHP/Laravel Sênior

Autor: Paulo Sérgio  
Email: paulosergiophp@gmail.com  
Telefone: (11) 9 3027 3040

## Objetivo

A API Restful que contempla os módulos Cliente, Produto e Pedido

## Instalação

Siga as instruções abaixo para configurar o projeto localmente:

1. Clone o repositório para sua máquina local:
   ```bash
   git clone https://github.com/PauloBoleiroFC/TestePHP_14_02_25.git

2. Acesse a pasta do projeto

3. Renomeio o arquivo .env.example para .env

4. Instale as dependências:
```bash
composer install
```

## Subir container
1. Criar um alias de shell que permita executar os comandos do Sail
```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
2. Subir container:
```bash
sail up -d
```

## Banco de dados
1. Para migrar a tabela, execute o comando:
```bash
sail artisan migrate
```

2. Popular tabela Produtos, execute:
```bash
sail artisan db:seed --class=ProductsSeeder
```

## Envio de emails
Para que o envio de emil seja realizados, é necessário configurar dados SMTP no arquivo .env

## Testes unitários
Para executar os testes, rode os comandos abaixo
```bash
sail artisan test --filter=CustomerControllerTest
```

```bash
sail artisan test --filter=ProductControllerTest
```

```bash
sail artisan test --filter=RequestControllerTest
```


