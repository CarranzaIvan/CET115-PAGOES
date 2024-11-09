#!/bin/sh

# Esperar a que el servicio de MySQL esté disponible
until nc -z -v -w30 db 3306
do
  echo "Esperando a MySQL..."
  sleep 5
done

echo "MySQL está listo."

# Instalar las dependencias de Composer si no están instaladas
if [ ! -d "vendor" ]; then
    composer install
fi

# Copiar .env.example a .env si no existe
if [ ! -f .env ]; then
    cp .env.example .env
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/' .env
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=ShinyGo/' .env
    sed -i 's/DB_USERNAME=root/DB_USERNAME=shinygo_user/' .env
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=admin123/' .env
fi

# Generar la clave de la aplicación si no existe
if ! grep -q "APP_KEY" .env || [ -z "$(grep 'APP_KEY' .env | cut -d '=' -f2)" ]; then
    php artisan key:generate
fi

# Ejecutar migraciones
php artisan migrate --force

# Verificar si PHP-FPM ya está corriendo
if ! pgrep php-fpm > /dev/null; then
    # Ejecutar PHP-FPM en primer plano si no está corriendo
    php-fpm -F
else
    echo "PHP-FPM ya está en ejecución."
fi
