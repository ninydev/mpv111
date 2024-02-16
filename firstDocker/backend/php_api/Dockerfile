FROM php:8.3-cli

RUN apt update
RUN apt install mc -y

# Внутри контейнера выберем рабочую папку - где будет распологаться мой код
WORKDIR /app

# Скопируем код из папки src в контейнер
COPY ./src /app

# Запустим laravel в режиме разработчика
CMD ["/app/artisan", "serve", "--host=0.0.0.0" ,"--port=8000"]
