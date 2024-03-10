.PHONY: run

up:
	sudo docker-compose -p wordpress -f .docker/src/docker-compose.yml --env-file .env up
