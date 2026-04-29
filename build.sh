#!/usr/bin/env bash
# exit on error
set -o errexit

composer install --no-dev --optimize-autoloader

# আর্কিটেকচার অনুযায়ী কমান্ড
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ডাটাবেজ মাইগ্রেশন (সাবধান: এটা ডাটা ডিলিট করতে পারে যদি ভুল করেন)
php artisan migrate --force
