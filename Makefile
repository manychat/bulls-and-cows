up: docker-up

init: docker-clear docker-up permissions api-composer

docker-clear:
	docker-compose down --remove-orphans
	sudo rm -rf var/docker

docker-up:
	docker-compose up --build -d

permissions:
	sudo chmod -R 777 var

api-composer:
	docker-compose exec php-cli composer install