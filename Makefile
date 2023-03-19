.PHONY: serve test setup run stop composer migrate

setup:
	docker-compose build

migrate:
	docker-compose exec -w /var/www/html/app app php artisan migrate

composer:
	docker-compose exec -w /var/www/html/app app composer install

run:
	docker-compose up

stop:
	docker-compose down

serve:
	docker-compose exec -w /var/www/html/app app php artisan serve --host=0.0.0.0 --port=8000

test:
	docker-compose exec -w /var/www/html/app app ./vendor/bin/phpunit --filter PostApiTest