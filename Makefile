install: env sail-install up composer-install keys migrate

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

composer-update:
	vendor/bin/sail composer update $(pkg)

composer-require:
	vendor/bin/sail composer require $(pkg)

art:
	vendor/bin/sail artisan $(cmd)

keys:
	vendor/bin/sail artisan key:generate && \
	vendor/bin/sail artisan jwt:secret && \
	vendor/bin/sail artisan jwt:generate-certs --force --algo=rsa --bits=4096 --sha=512

migrate:
	vendor/bin/sail artisan migrate

test:
	vendor/bin/sail artisan test
