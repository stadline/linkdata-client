SHELL = /bin/sh
.DEFAULT_GOAL := help

.PHONY: install-prod
install-prod: ## Install project and dependencies
	composer install -o -n --prefer-dist --no-progress --no-suggest --ansi
	composer dump-autoload --optimize --classmap-authoritative

.PHONY: test-cs-fixer
test-cs-fixer: ## Launches php-cs-fixer test
	php vendor/bin/php-cs-fixer fix --dry-run --diff --no-ansi

.PHONY: phpstan
phpstan: ## Launches phpstan test
	php -d memory_limit=256M vendor/bin/phpstan analyse -l5 --ansi src

.PHONY: local-requirements
local-requirements: ## Launches requirements test
	php --version
	php vendor/bin/phpstan --version
	php vendor/bin/php-cs-fixer --version
	composer --version

.PHONY: cs-fixer
cs-fixer: ## Launches php-cs-fixer fix
	php vendor/bin/php-cs-fixer fix --no-ansi

.PHONY: help
help: ## Show help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'
