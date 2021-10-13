## Clone the project
1) git clone https://github.com/OleksiiFedorchak/test-task-crud-cars.git

## Install laradock:
1) cd test-task-crud-cars
2) git clone https://github.com/Laradock/laradock.git
3) cd laradock && cp .env.example .env
4) docker-compose up -d nginx mariadb redis workspace

## Up project
1) cd test-task-crud-cars
2) docker-compose exec workspace bash //your docker should be running
3) php -v //check your php container is up
4) composer install
5) cp .env.example .env
6) set your db credentials in .env file 
(as a host parameter please use 'mariadb')
7) php artisan migrate
8) php artisan db:seed

## Test project
1) cd test-task-crud-cars
2) docker-compose exec workspace bash //your docker should be running
3) php artisan test
