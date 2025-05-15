# Inicializar o projeto
Copiar o arquivo .env
``` cp .env.example .env ```

Inicializar o docker
``` docker-compose up -d ```

Instalar as dependências do projeto
``` docker-compose exec laravel-app composer install ```

Gerar a chave da aplicação 
``` docker-compose exec laravel-app php artisan key:generate ``` 

Rode os migrations 
 ``` docker exec laravel-app php artisan migrate ```

# Acesse no endereço local
``` localhost:8000  ```

# Inicializar os teste
``` ./vendor/bin/phpunit tests/Unit ```
e
``` ./vendor/bin/phpunit tests/Feature ```

Os testes serão divididor em pastas por entidade: Exemplo Unit/Tutor Unit/Animal