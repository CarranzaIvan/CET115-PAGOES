# Usar la imagen oficial de PHP con PHP-FPM
FROM php:8.2-fpm

# Instalar extensiones necesarias para Laravel y otras utilidades
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    curl \
    gnupg \
    netcat-openbsd \
    net-tools \ 
    && docker-php-ext-install pdo pdo_mysql zip mbstring

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Node.js y NPM (versión 18.x)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . .

# Copiar y dar permisos al script de entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Dar permisos a las carpetas necesarias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Exponer el puerto de PHP-FPM
EXPOSE 9000

# Usar el entrypoint personalizado
ENTRYPOINT ["/bin/sh", "/entrypoint.sh"]
