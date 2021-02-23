Для локального окружения используется Docker с php7.3/MySQL/nginx.

Разработка велась на линуксе (на винде вероятно конфиг и инструкции могут отличаться).

## Как развернуть
- Скопировать\переименовать .env.example в .env `mv .env.example .env`
- В .env файле:
 ```
 DB_HOST=mysql
 DB_PORT=33061
 DB_USERNAME=app
 DB_PASSWORD=secret
 ```
- *Для проблемы с правами в линуксе*: Если id пользователя хост-машины не 1000, добавить в .env файл USER_ID и GROUP_ID в с текущим id (`id` в терминале). Например: `USER_ID=1000` `GROUP_ID=1000`. Или тупо chmod
- `composer install`
- Для старта сервера
`sudo docker-compose up`
- Сгенерить ключ `php artisan key:generate`
- Пролинковать хранилище `php artisan storage:link`
- Для стилей и скриптов `npm install && npm run prod`
- Применить миграции `sudo docker-compose exec php-cli php artisan migrate`
- Перейти по адресу [https://localhost:8080](https://localhost:8080)


## Как создать менеджера
- Зарегистрировать пользователя
- Выполнить artisan команду, подставив туда почту пользователя с предыдущего шага `sudo docker-compose exec php-cli php artisan manager:make manager@example.com`

## Telegram
При создании заявки бот публикует сообщение в канале Telegram. Чтобы включить нужно добавить API ключ бота и числовой chat_id канала в .env файл
```
TELEGRAM_API_KEY=ключ бота
TELEGRAM_CHANNEL_ID=числовой идентификатор канала
```
