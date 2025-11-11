.PHONY: build up down logs shell

COMPOSE_DIR := docker/development

build:
	cd $(COMPOSE_DIR) && docker-compose -f docker-compose.yml build

up:
	cd $(COMPOSE_DIR) && docker-compose -f docker-compose.yml up -d

down:
	cd $(COMPOSE_DIR) && docker-compose -f docker-compose.yml down

logs:
	cd $(COMPOSE_DIR) && docker-compose -f docker-compose.yml logs -f

shell:
	cd $(COMPOSE_DIR) && docker-compose -f docker-compose.yml exec app bash
