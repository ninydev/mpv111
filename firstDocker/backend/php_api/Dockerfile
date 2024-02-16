FROM php:8.3-cli
# Открываем порт для доступа к приложению
EXPOSE 8000

RUN apt update
RUN apt install mc unzip -y

# Внутри контейнера выберем рабочую папку - где будет распологаться мой код
WORKDIR /app

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install pdo pdo_mysql

# Установка дополнительных расширений PHP для Redis
RUN pecl install redis && docker-php-ext-enable redis
# Установка библиотеки ImageMagick и её заголовочных файлов
RUN apt-get install -y libmagickwand-dev
# Установка расширения Imagick
RUN pecl install imagick && docker-php-ext-enable imagick


# Скопируем код из папки src в контейнер
COPY ./src /app
RUN composer install

# Запустим laravel в режиме разработчика
CMD ["/app/artisan", "serve", "--host=0.0.0.0" ,"--port=8000"]
