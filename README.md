Inicializar o projeto

# Copiar o arquivo .env
```` cp .env.example .env
````

# Inicializar o docker
```` docker-compose up -d
````

# Instalar as dependências do projeto
 ```` docker-compose exec laravel-app composer install ```` 

# Gerar a chave da aplicação 
``` docker-compose exec laravel-app php artisan key:generate ``` 


Acesse pelo navegador 
``` localhost:8000  ```