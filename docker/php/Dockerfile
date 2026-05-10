# ステージ 1: Vite でフロントをビルド（clone 先に public/build が無くても動かす）
FROM node:20-bookworm-slim AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ステージ 2: PHP-FPM
FROM php:8.2-fpm-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl zip unzip \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libwebp-dev \
    libzip-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring exif pcntl bcmath gd zip opcache \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ホストに public/build が無いとき entrypoint がここからコピーする
COPY --from=frontend /app/public/build /opt/laravel-public-build

COPY docker/php/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/php/docker-entrypoint.sh /usr/local/bin/app-docker-entrypoint.sh
RUN chmod +x /usr/local/bin/app-docker-entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["app-docker-entrypoint.sh"]
CMD ["php-fpm", "-F"]
