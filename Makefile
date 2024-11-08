up:
	docker-compose up -d

init:
	docker-compose exec php composer install && \
	docker-compose exec php bin/console doctrine:database:create --if-not-exists && \
	docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction

start:
	make up
	make init
