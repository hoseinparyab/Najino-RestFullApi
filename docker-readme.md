# راهنمای استفاده از داکر برای پروژه Najino-RestFullApi

## پیش‌نیازها
- نصب [Docker](https://www.docker.com/get-started)
- نصب [Docker Compose](https://docs.docker.com/compose/install/)

## راه‌اندازی پروژه با داکر

### گام 1: کپی فایل .env.docker به .env
```bash
cp .env.docker .env
```

### گام 2: ساخت و راه‌اندازی کانتینرها
```bash
docker-compose up -d
```

### گام 3: وارد شدن به کانتینر اپلیکیشن
```bash
docker-compose exec app bash
```

### گام 4: نصب وابستگی‌ها
```bash
composer install
```

### گام 5: ایجاد کلید اپلیکیشن
```bash
php artisan key:generate
```

### گام 6: اجرای مایگریشن‌ها
```bash
php artisan migrate
```

### گام 7: اجرای سیدرها (اختیاری)
```bash
php artisan db:seed
```

## دسترسی به سرویس‌ها
- وب‌سایت: http://localhost
- پایگاه داده: 
  - هاست: localhost
  - پورت: 3306
  - نام کاربری: najino
  - رمز عبور: najino_password
  - نام دیتابیس: najino_restfullapi

## دستورات مفید

### مشاهده لاگ‌ها
```bash
docker-compose logs -f
```

### توقف کانتینرها
```bash
docker-compose down
```

### اجرای دستورات آرتیزان
```bash
docker-compose exec app php artisan [command]
```

### بازسازی کانتینرها
```bash
docker-compose down
docker-compose up -d --build
```

## ساختار فایل‌های داکر
- `Dockerfile`: تنظیمات ساخت تصویر PHP
- `docker-compose.yml`: تعریف و پیکربندی سرویس‌ها
- `.dockerignore`: فایل‌هایی که نباید در تصویر داکر کپی شوند
- `nginx/conf.d/app.conf`: تنظیمات Nginx
- `php/local.ini`: تنظیمات PHP
- `mysql/my.cnf`: تنظیمات MySQL
- `.env.docker`: متغیرهای محیطی برای محیط داکر
