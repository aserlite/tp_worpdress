#!/bin/bash

echo "Registering docker.host.ip ..."
echo "$(ip route show default | awk '/default/ {print $3}')" "$(echo "docker.host.ip")" >> /etc/hosts