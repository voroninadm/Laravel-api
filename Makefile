.PHONY: help install setup test swagger docker-up docker-down fresh lint analyse

# For Laravel Sail
SAIL=./vendor/bin/sail

# Colors
GREEN=\033[0;32m
NC=\033[0m

# Default target
help:
	@echo "Available commands:"
	@echo "  make install     - Install dependencies"
	@echo "  make setup       - Setup application (key, migrate, seed)"
	@echo "  make test        - Run tests"
	@echo "  make swagger     - Generate Swagger API documentation"
	@echo "  make up          - Start Docker containers (Sail)"
	@echo "  make down        - Stop Docker containers (Sail)"
	@echo "  make fresh       - Fresh migrate with seed"

# Install dependencies
install:
	$(SAIL) composer install
	$(SAIL) npm install

# Setup application
setup:
	cp .env.example .env
	$(SAIL) artisan key:generate
	$(SAIL) artisan migrate --seed
	$(SAIL) artisan storage:link
	@echo "${GREEN}Application setup completed!${NC}"

# Run tests
test:
	$(SAIL) php artisan test
# Docker commands (Sail)
up:
	$(SAIL) up -d
	@echo "${GREEN}Containers started!${NC}"

down:
	$(SAIL) down
	@echo "${GREEN}Containers stopped!${NC}"

build:
	$(SAIL) build --no-cache

# Cache operations
cache-clear:
	$(SAIL) artisan cache:clear
	$(SAIL) artisan config:clear
	$(SAIL) artisan route:clear
	$(SAIL) artisan view:clear
	@echo "${GREEN}Cache cleared!${NC}"

cache-warm:
	$(SAIL) artisan config:cache
	$(SAIL) artisan route:cache
	$(SAIL) artisan view:cache
	@echo "${GREEN}Cache warmed!${NC}"

# Database operations
fresh:
	$(SAIL) artisan migrate:fresh --seed
	@echo "${GREEN}Database refreshed and seeded!${NC}"


# Production deployment
deploy: install cache-clear cache-warm
	$(SAIL) artisan migrate --force
	@echo "${GREEN}Deployment completed!${NC}"

# Swagger documentation
swagger:
	$(SAIL) artisan l5-swagger:generate
	@echo "${GREEN}Swagger docs generated at: http://localhost/api/documentation${NC}"

# Quick start (for new developers)
start: up install setup swagger
	@echo "${GREEN}Project is ready! Access at: http://localhost${NC}"
