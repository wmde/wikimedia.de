# If the first argument is "composer"...
ifeq (composer,$(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "composer"
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(RUN_ARGS):;@:)
endif

.PHONY: ci test phpunit cs stan covers composer

ci: test cs

test: phpunit

cs: phpcs stan

phpunit:
	docker-compose run --rm php-fpm ./vendor/bin/phpunit

phpcs:
	docker-compose run --rm php-fpm ./vendor/bin/phpcs -p -s

stan:
	docker-compose run --rm php-fpm ./vendor/bin/phpstan analyse --level=1 --no-progress src/ tests/
