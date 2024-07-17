# Transações e Estatísticas

Este projeto é uma API RESTful para estatísticas de transações. Ele calcula estatísticas em tempo real para os últimos 60 segundos de transações.

## Pré-requisitos

-   Docker
-   Docker Compose
-   PHP 8.2
-   Rabbitmq
-   Composer

## Configuração do Ambiente

### Configurando as variáveis de ambiente

1. Copie o arquivo de exemplo de variáveis de ambiente e edite conforme necessário:

    ```bash
    cp .env.example .env
    ```

2. Configure o TTL da fila de transações no arquivo .env:
    ```bash
    TRANSACTION_TTL=definir_ttl(inteiro)
    ```

### Subindo o Docker

1. Clone este repositório:

    ```bash
    git clone https://github.com/mauricio-berani/prec-pago.git
    cd seu-repositorio
    ```

2. Suba os containers Docker:
    ```bash
    docker-compose up -d
    ```

### Instalação do Composer

1. Instale as dependências do Composer:
    ```bash
    composer install
    ```

## Uso das Rotas

### POST /transactions

Endpoint para criar uma nova transação.

**Corpo da Requisição:**

```json
{
    "amount": "12.3343",
    "timestamp": "2018-07-17T09:59:51.312Z"
}
```

**Respostas Possíveis:**

-   `201 Created`: Sucesso
-   `204 No Content`: Transação mais antiga que ttl definido
-   `400 Bad Request`: JSON inválido
-   `422 Unprocessable Entity`: Campos inválidos ou data no futuro
-   `500 Server Error`: Erro do servidor

**Exemplo de Requisição:**

```bash
curl -X POST {base_url}/api/transactions     -H "Content-Type: application/json"     -d '{"amount":"12.3343", "timestamp":"2018-07-17T09:59:51.312Z"}'
```

### GET /statistics

Endpoint para obter as estatísticas das transações dos últimos 60 segundos.

**Resposta:**

```json
{
    "sum": "1000.00",
    "avg": "100.53",
    "max": "200000.49",
    "min": "50.23",
    "count": 10
}
```

**Exemplo de Requisição:**

```bash
curl {base_url}/api/statistics
```

### DELETE /transactions

Endpoint para excluir todas as transações.

**Resposta:**

-   `204 No Content`

**Exemplo de Requisição:**

```bash
curl -X DELETE {base_url}/api/transactions
```
