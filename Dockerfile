FROM php:7.4.2-apache
RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get install msmtp ca-certificates curl -y
RUN sed -i -e "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf
RUN echo "LoadModule rewrite_module modules/mod_rewrite.so" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite
RUN service apache2 restart
RUN curl -o ~/.msmtprc *******your msmtp config file*********(i upload mine on mediafire)
RUN chmod 600 ~/.msmtprc && cp -p ~/.msmtprc /etc/.msmtp_php && chown www-data:www-data /etc/.msmtp_php
RUN touch /var/log/msmtp.log && chown www-data:www-data /var/log/msmtp.log
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN rm -rf /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini-production
RUN echo "sendmail_path = \"/usr/bin/msmtp -C /etc/.msmtp_php --logfile /var/log/msmtp.log -a amazon -t\"" >> /usr/local/etc/php/php.ini
