#!/bin/bash
# start.sh - Script startup untuk Railway

echo "🚀 Memulai server PHP di port $PORT..."

# Masuk ke folder api dan jalankan PHP built-in server
cd api

# Jalankan server dengan document root di folder api
php -S 0.0.0.0:$PORT