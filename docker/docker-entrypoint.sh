#!/bin/sh
set -e

mkdir -p /app/public/images/affiliates/
chmod -R 777 /app/public/images/affiliates/
mkdir -p /app/public/images/joined/
chmod -R 777 /app/public/images/joined/
mkdir -p /app/public/images/owned/
chmod -R 777 /app/public/images/owned/
chmod -R 777 /app/public/images/

exec "$@"
