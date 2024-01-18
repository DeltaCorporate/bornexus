# Utilisation de PHP 8.1 FPM comme image de base
FROM php:8.1

# Installation des dépendances nécessaires pour Symfony et les extensions PHP
RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        git \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installation de la CLI Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Définition du répertoire de travail
WORKDIR /var/www

# Copie du code source de l'application dans le conteneur
COPY . .

# Installation des dépendances Composer
RUN composer install --no-interaction

RUN symfony server:ca:install

# Commande pour démarrer PHP-FPM
CMD ["symfony"]
