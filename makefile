# Variables
DOCKER_COMPOSE = docker-compose
PHP_CONTAINER = php
CONSOLE_COMMAND = php bin/console

# Targets
.PHONY: composer php console

composer:
	$(DOCKER_COMPOSE) exec $(PHP_CONTAINER) composer $(MAKECMDGOALS)

php:
	$(DOCKER_COMPOSE) exec $(PHP_CONTAINER) php $(MAKECMDGOALS)

console:
	$(DOCKER_COMPOSE) exec $(PHP_CONTAINER) $(CONSOLE_COMMAND) $(MAKECMDGOALS)

update-db:
	$(DOCKER_COMPOSE) exec $(PHP_CONTAINER) php bin/console orm:schema-tool:update --complete --force

npm:
	$(DOCKER_COMPOSE) exec $(PHP_CONTAINER) $(MAKECMDGOALS)


# To avoid errors when running make with additional arguments
%:
	@:
