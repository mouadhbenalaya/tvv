PHP_UP := $(shell docker ps --format '{{.Names}}' | grep php)
GREEN := "\e[92m"
STOP="\e[0m"
WORKDIR=.local
DOCKER_FILE=${WORKDIR}/docker-compose.yml
ENV_FILE=${WORKDIR}/../.env
PHP_VERSION=8.3

default:
	@printf ${GREEN}
	@echo 'Documentation for Laravel Skeleton make commands:'
	@printf ${STOP}
	@echo '----------------------------------------------'
	@echo '  install        : will install and configure the whole skeleton project'
	@echo '  ssh-php        : ssh into PHP container'
	@echo '  ssh-db         : ssh into DB container'
	@echo '  ssh-nginx      : sash into nginx container'
	@echo '  tail-nginx     : tail nginx logs'
	@echo '  test           : run functional tests'
	@echo '  docs           : regenerate documentation'
	@echo '  postman        : export postman collection'
	@echo '  up             : boot up containers'
	@echo '  down           : shut down containers'
	@echo '  health         : show JSON prettified healthcheck info'
	@echo '  wipe           : reset to factory settings'
	@echo '  phpstan        : run phpstan to scan your code and looks for both obvious & tricky bugs'
	@echo '  cs-fix         : run cs-fixer to fix code style'
	@echo '----------------------------------------------'
	@echo ' '

install:
	$(info Running Q Laravel installation script, this might take a minute...)
	export PHP_VERSION=${PHP_VERSION}
	cp .env.local .env
	cp .local/docker-compose.yml.dist ${DOCKER_FILE}
	docker-compose -f ${DOCKER_FILE} --env-file=${ENV_FILE} up --detach --force-recreate --build
	docker-compose -f ${DOCKER_FILE} exec php /bin/bash /home/quser/qsetup.sh
	curl -IL -k https://localhost/docs

ssh-php:
	$(info SSH into PHP container...)
	docker exec -it tamkeen_php /bin/bash

ssh-db:
	$(info SSH into DB container...)
	docker exec -it tamkeen_db /bin/bash

ssh-nginx:
	$(info SSH into NGINX container...)
	docker exec -it tamkeen_nginx /bin/sh

tail-nginx:
	$(info Showing logs from nginx...)
	docker exec -it tamkeen_nginx tail -f /var/log/nginx/error.log

docs:
	$(info Running documentation regeneration)
	docker exec -it tamkeen_php php artisan l5-swagger:generate

postman:
	$(info Exporting Postman documentation)
	docker exec -it tamkeen_php php artisan export:postman

test:
	$(info Running functional tests, this might take a few minutes...)
	docker exec -it tamkeen_php vendor/bin/phpunit

up:
	$(info Booting up docker containers...)
	docker-compose -f ${DOCKER_FILE} --env-file=${ENV_FILE} up -d

down:
	$(info Shutting down docker containers...)
	docker-compose -f ${DOCKER_FILE} down

health:
	@curl -X GET http://localhost/status -H 'Accept: application/json' -H 'Content-Type: application/json' | jq

wipe:
	@echo -n "Fam, we about to nuke everything to factory settings! "
	@echo -n "Are you sure? [y/N] " && read ans && [ $${ans:-N} = y ]
	docker-compose -f ${DOCKER_FILE} stop
	docker-compose -f ${DOCKER_FILE} rm -v --force
	rm -rf .env .php-cs-fixer.cache .phpunit.result.cache vendor
	unset PHP_VERSION

phpstan:
	$(info Running phpstan to scan your code and looks for both obvious & tricky bugs)
	docker exec -it tamkeen_php composer phpstan

cs-fix:
	$(info Running cs-fixer to fix code style)
	docker exec -it tamkeen_php composer cs-fixer-fix
