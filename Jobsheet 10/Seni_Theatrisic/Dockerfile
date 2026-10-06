# Dockerfile

# ============================================
# STAGE 1: Base Image
# ============================================
FROM php:8.2-cli-alpine

# ============================================
# STAGE 2: Install Ekstensi PostgreSQL
# ============================================
RUN apk add --no-cache \
    postgresql-dev \
    bash \
    curl \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# ============================================
# STAGE 3: Set Working Directory
# ============================================
WORKDIR /app

# ============================================
# STAGE 4: Copy Semua File Proyek
# ============================================
COPY . .

# ============================================
# STAGE 5: Berikan Izin Eksekusi ke start.sh
# ============================================
RUN chmod +x start.sh

# ============================================
# STAGE 6: Expose Port (Railway akan override)
# ============================================
EXPOSE 8080

# ============================================
# STAGE 7: Jalankan Start Script
# ============================================
CMD ["bash", "start.sh"]