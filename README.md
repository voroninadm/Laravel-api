<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About project
Проект для знакомства со slim-скелетоном Laravel 12 и отработки навыков создания api.
Без LaravelBreeze, но с Sanctum.

### init
Инициализация проекта. Сделанные шаги:
1. Локализация (laravel-lang/lang).
- ``composer require --dev laravel-lang/lang``
- Меняем локали и настройки в .env, в config/app.php прописываем ``'timezone' => env('APP_TIMEZONE', 'UTC'),`` и
в .env добавляем ``APP_TIMEZONE=Europe/Moscow  TZ=Europe/Moscow``
2. Добавляем api.
- ``php artisan install:api`` - установится sanctum и добавятся роуты api
3. Добавляем MYSQL_EXTRA_OPTIONS в .env
4. ``php artisan storage:link`` - делаем ссылку на хранилище
В config/filesystems создана ссылка для хранения аватарок``public_path('avatars') => storage_path('app/avatars')`` 
Сохраненные файлы летят в /storage/avatars/{avatar_name}
5. В App\Providers\AppServiceProvider (boot) добавлен RateLimiter для api. 20 запросов в минуту
6. Добавлен RateLimiter в UserLoginRequest - 5 попыток для входа, 60 сек бан
7. В config/sanctum задан срок жизни токена 1440 минут - сутки
8. В routes/console добавлена команда Sanctum для ежесуточной очистки токенов, протухших за 24 часа.
Для тестирования по расписанию не забываем выполнить ``php artisan schedule:run``
