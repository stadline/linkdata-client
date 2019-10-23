SHELL = /bin/sh
.DEFAULT_GOAL := help

V = 0
Q = $(if $(filter 1,$V),,@)
M = $(shell printf "\033[34;1m▶\033[0m")

##
## Tests
.PHONY: test
test: test-cs-fixer phpstan test-lost-dev-code ## Launches tests

.PHONY: test-code-smell
test-code-smell: test-cs-fixer phpstan test-lost-dev-code ## Launches test-code-smell

.PHONY: test-cs-fixer
test-cs-fixer: ; $(info $(M) Test cs-fixer…) @ ## Launches php-cs-fixer test
	$Q php vendor/bin/php-cs-fixer fix --dry-run --diff --no-ansi

.PHONY: test-lost-dev-code
test-lost-dev-code: ; $(info $(M) Test lost dev code…) @ ## Launches lost dev code test
	$Q printf "===> \033[1;34mSearch for Behat lost dev code ...\033[0m\n" && \
	grep -rnw 'features' -e 'print last' && printf "die" && printf "\n" && exit 1 || printf "\033[1;32mNothing found !\033[0m\n" && exit 0

	$Q printf "===> \033[1;34mSearch for var_dump, dump or die lost dev code ...\033[0m\n" && \
	grep -rnw 'src' -e ' var_dump' -e ' dump' -e 'die' && printf "\n" && exit 1 || printf "\033[1;32mNothing found !\033[0m\n" && exit 0

##
## Phpstan
.PHONY: phpstan
phpstan: ; $(info $(M) Test phpstan…) @ ## Launches phpstan test
	$Q php -d memory_limit=256M vendor/bin/phpstan analyse -c phpstan.neon -l5 --ansi src tests

##
## CS-fixer
.PHONY: cs-fixer
cs-fixer: ; $(info $(M) Apply cs-fixer…) @ ## Launches php-cs-fixer fix
	$Q php vendor/bin/php-cs-fixer fix --no-ansi


##
## General
.PHONY: help
help: ## Show help
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'