#!/bin/zsh

usermod -u ${DOCKER_WWW_DATA_UID} www-data && groupmod -g ${DOCKER_WWW_DATA_GID} www-data
