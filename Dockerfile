# Usamos la imagen oficial de PHP con FPM y la versión 8.2
FROM php:8.2-fpm

# Instalamos extensiones y herramientas necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install zip pdo_mysql

# Instalamos Composer copiándolo desde la imagen oficial de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecemos el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiamos todos los archivos del proyecto al contenedor
COPY . .

# Instalamos dependencias PHP con Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Generamos la llave de la app (opcional, puedes hacerlo también en Render)
RUN php artisan key:generate

# Expone el puerto 9000 para PHP-FPM
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
