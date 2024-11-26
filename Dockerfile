# Menggunakan image PHP resmi
FROM php:8.2-apache

# Copy source code aplikasi ke dalam container
COPY . /var/www/html

# Mengatur permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Instal ekstensi PHP yang diperlukan (contoh: mysqli untuk MySQL)
RUN docker-php-ext-install mysqli

# Aktifkan modul Apache rewrite (jika diperlukan)
RUN a2enmod rewrite

# Expose port default Apache
EXPOSE 80
