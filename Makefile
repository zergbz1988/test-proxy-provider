install: env sail-install up composer-install

env:
	test -s .env || cp .env.example .env

sail-install:
	docker run --rm --interactive --tty \
    --volume $${PWD}:/app -w /app \
    --user $(id -u):$(id -g) \
	laravelsail/php81-composer:latest \
	bash -c "composer require --dev laravel/sail && php artisan sail:install --with=pgsql,redis"

composer-install:
	vendor/bin/sail composer install $(pkg)

up:
	vendor/bin/sail up -d --remove-orphans

down:
	vendor/bin/sail down


