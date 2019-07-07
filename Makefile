docker-up:
	docker-compose up -d

docker-build:
	docker-compose up -d --build

docker-down:
	docker-compose down

docker-bash:
	docker-compose exec php-fpm bash
