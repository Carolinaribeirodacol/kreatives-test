# Meu App Fullstack

Este é um projeto FULL STACK com Laravel + Sanctum no backend e Vue + Pinia no frontend, separados em dois diretórios e containerizados com Docker.

## Como executar

### Pré-requisitos

- Docker
- Docker Compose
- Porta 3000 e 5050 livres (ou ajuste no docker-compose.yml)

### Como rodar o projeto localmente

1. Clone o repositório:
   ```sh
   git clone <url-do-repositorio>
   cd kreatives-test
   ```

2. Copie os arquivos .env para o backend e o frontend
   ```sh
      cp backend/.env.example backend/.env
      cp frontend/.env.example frontend/.env
   ```

   Edite os arquivos se quiser alterar host, portas, domínios, banco etc.

3. Build e subida dos containers
   ```sh
      docker-compose up --build -d
      docker-compose exec backend composer install
   ```

4. Gere a chave de aplicação do Laravel
   ```sh
      docker-compose exec backend php artisan key:generate
   ```

5. Execute as migrations e seeders
   ```sh
      docker-compose exec backend php artisan migrate --seed
   ```

6. Corrija permissões (Linux/macOS)
   ```sh
     sudo chown -R $USER:$USER backend/storage backend/bootstrap/cache
   ```

7. Acesse no navegador
   Frontend: http://localhost:3000
   Backend (API): http://localhost:5050

### Variáveis de ambiente importantes
Backend (backend/.env)
```sh
   APP_URL=APP_URL=http://localhost:5000
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=kreative
   DB_USERNAME=root
   DB_PASSWORD=root

   SANCTUM_STATEFUL_DOMAINS=localhost:3000
   SESSION_DOMAIN=localhost
```

### Testar login
   Use os dados do seeder (email:admin@admin.com / password: senha123).