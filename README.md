# Meu App Fullstack

Este é um projeto FULL STACK separado em um backend (Laravel + Sanctum) e frontend (Vue + Pinia). Ambos são containerizados com Docker, facilitando o deploy e o gerenciamento dos serviços.

## Como executar

### Pré-requisitos

- Docker
- Docker Compose
- Banco de dados configurado (ex: MySQL, PostgreSQL)

### Passos para rodar o projeto

1. Clone o repositório:
   ```sh
   git clone <url-do-repositorio>
   cd kreatives-test
   ```

2. Execute os containers com Docker Compose:
   ```sh
   docker-compose up --build
   ```
   > Para rodar em segundo plano, use: `docker-compose up --build -d`

3. Abra um novo terminal e rode as migrations e seeders dentro do container backend:
   ```sh
   docker-compose exec backend php artisan migrate --seed
   ```
   > Isso garante que o banco esteja montado e populado para uso.

4. Para parar os containers:
   ```sh
   docker-compose down
   ```

### Acesso aos serviços

- Frontend disponível em: `http://localhost:3000`
- Backend disponível em: `http://localhost:5050` (ou porta configurada)