# পিএইচপি ৮.২ এর অফিসিয়াল ইমেজ ব্যবহার করছি
FROM php:8.2-fpm

# প্রয়োজনীয় সিস্টেম ডিপেন্ডেন্সি ইন্সটল
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# পিএইচপি এক্সটেনশন ইন্সটল (লারাভেলের জন্য মাস্ট)
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# কম্পোজার কপি করা
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# প্রজেক্টের ফাইল ডকার কন্টেইনারে নেওয়া
WORKDIR /var/www
COPY . .

# ডিপেন্ডেন্সি ইন্সটল
RUN composer install --no-dev --optimize-autoloader



# পোর্ট এক্সপোজ করা (রেন্ডার সাধারণত ১০০০০ পোর্ট ব্যবহার করে)
EXPOSE 10000

# সার্ভার চালু করার কমান্ড
CMD php artisan serve --host=0.0.0.0 --port=10000


# ... আগের কোড ...

# পারমিশন ঠিক করা
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ডেপ্লয় হওয়ার সময় অটোমেটিক মাইগ্রেশন হবে
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
