current_user  := $(shell id -u)
current_group := $(shell id -g)
BUILD_DIR     := $(PWD)
DOCKER_FLAGS  := --interactive --tty
COMPOSER_FLAGS :=

.DEFAULT_GOAL := ci

.PHONY: ci test phpunit cs stan covers composer install update

ci: test cs

test: phpunit

cs: phpcs stan

phpunit:
	docker-compose run --rm php-fpm ./vendor/bin/phpunit

phpcs:
	docker-compose run --rm php-fpm ./vendor/bin/phpcs -p -s

stan:
	docker-compose run --rm php-fpm ./vendor/bin/phpstan analyse --level=1 --no-progress src/ tests/

install:
	docker run --rm $(DOCKER_FLAGS) --volume $(BUILD_DIR):/app -w /app --volume ~/.composer:/composer --user $(current_user):$(current_group) composer install --ignore-platform-reqs $(COMPOSER_FLAGS)

update:
	docker run --rm $(DOCKER_FLAGS) --volume $(BUILD_DIR):/app -w /app --volume ~/.composer:/composer --user $(current_user):$(current_group) composer update --ignore-platform-reqs $(COMPOSER_FLAGS)

services:
	docker-compose run --rm php-fpm php bin/console debug:autowiring