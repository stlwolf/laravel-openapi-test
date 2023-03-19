.PHONY: serve test

serve:
	docker-compose exec -w /var/www/html/app app php artisan serve --host=0.0.0.0 --port=8000

test:
	docker-compose exec -w /var/www/html/app app ./vendor/bin/phpunit --filter PostApiTest