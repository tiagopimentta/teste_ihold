CONTAINER_NAME=test_app

# Sobe o sistema
up:
	docker-compose up --build -d

# gera o secret JWT
jwt:
	docker exec -t $(CONTAINER_NAME) bash  -c "php artisan jwt:secret"

# gera as migrations and seeders
db:
	docker exec -t $(CONTAINER_NAME) bash  -c "php artisan migrate:fresh --seed"

# entra no bash do container
bash:
	docker exec -it $(CONTAINER_NAME) bash

# Limpa os caches, gera as entities e os proxies
clear:
	docker exec $(CONTAINER_NAME) bash  -c "php artisan optimize:clear"

# Derruba o container
down:
	docker-compose down


# Roda os testes unitário.
# Se houver o parâmetro group, então executa apenas o group ex: make docker-test group=test-especifico-test
test:
ifdef group
	docker exec -t $(CONTAINER_NAME) ./vendor/bin/phpunit --group="$(group)" --stop-on-failure
else
	docker exec -t $(CONTAINER_NAME) ./vendor/bin/phpunit --stop-on-failure
endif

token:
	docker exec $(CONTAINER_NAME) bash  -c "php artisan jwt:token"

env:
	docker exec $(CONTAINER_NAME) bash  -c "cp .env.example .env"

composer:
	docker exec $(CONTAINER_NAME) bash  -c "composer install"
