.PHONY: seed
seed:
	php artisan migrate:fresh
	php artisan db:seed