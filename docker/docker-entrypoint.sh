#!/bin/sh
set -e

mkdir -p /app/public/enthusiast/affiliates/
chmod -R 777 /app/public/enthusiast/affiliates/
mkdir -p /app/public/enthusiast/joined/
chmod -R 777 /app/public/enthusiast/joined/
mkdir -p /app/public/enthusiast/owned/
chmod -R 777 /app/public/enthusiast/owned/

exec "$@"
