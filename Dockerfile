FROM php:8.3-cli

# Instalar dependencias del sistema y la extensión pdo_mysql para Aiven
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Copiar Composer desde su imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /app

# Copiar los archivos del proyecto
COPY . .

# Instalar dependencias de Composer para producción
RUN composer install --optimize-autoloader --no-dev

# Crear carpetas de almacenamiento obligatorias y otorgar permisos completos
RUN mkdir -p /app/storage/framework/cache/data \
    && mkdir -p /app/storage/framework/sessions \
    && mkdir -p /app/storage/framework/views \
    && mkdir -p /app/storage/logs \
    && chmod -R 777 /app/storage /app/bootstrap/cache

# Exponer el puerto nativo de Render
EXPOSE 10000

CMD php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000