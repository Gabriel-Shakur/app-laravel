FROM php:8.2-cli

# Instalar extensiones necesarias y herramientas
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev

# Exponer puerto HTTP que Laravel usa por defecto (por ejemplo 8000)
EXPOSE 8000

# Iniciar el servidor Laravel (php artisan serve)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

