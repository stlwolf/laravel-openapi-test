.PHONY: serve

serve:
	docker-compose exec -w /var/www/html/app app php artisan serve --host=0.0.0.0 --port=8000
