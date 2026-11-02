FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Write a clean VirtualHost config with AllowOverride All + port 8080
# (Vercel containers MUST use port 8080)
RUN cat > /etc/apache2/sites-available/000-default.conf << 'EOF'
<VirtualHost *:8080>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html

    <Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# Make Apache listen on 8080 instead of 80
RUN sed -i 's/^Listen 80$/Listen 8080/' /etc/apache2/ports.conf

WORKDIR /var/www/html

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 8080

CMD ["apache2-foreground"]
