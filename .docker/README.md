### Pre-flight checks

docker -v
docker-compose --version

### Needed ENV

export DOCKER_WWW_DATA_GID=$(id -g)
export DOCKER_WWW_DATA_UID=$(id -u)

### Start app

docker-compose -p wordpress -f .docker/src/docker-compose.yml --env-file .env up

You can add -d to run task in background

### Connect to container
docker-compose -p wordpress -f .docker/src/docker-compose.yml --env-file .env exec  app /bin/bash
