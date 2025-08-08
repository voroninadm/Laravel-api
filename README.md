<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About project
Проект для знакомства со slim-скелетоном Laravel 12 и отработки навыков создания api

### init
Инициализация проекта:
1. Локализация (laravel-lang/lang).
- ``composer require --dev laravel-lang/lang``
- Меняем локали и настройки в .env, в config/app.php прописываем ``'timezone' => env('APP_TIMEZONE', 'UTC'),`` и
в .env добавляем ``APP_TIMEZONE=Europe/Moscow  TZ=Europe/Moscow``
2. Добавляем api.
- ``php artisan install:api`` - установится sanctum и добавятся роуты api
3. Добавляем MYSQL_EXTRA_OPTIONS в .env
