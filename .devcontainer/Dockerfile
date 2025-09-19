FROM php:8.4-cli

# +-----------------------------+
# | METADATA                    |
# +-----------------------------+

LABEL org.opencontainers.image.vendor="Jens A. Koch"
LABEL org.opencontainers.image.source="https://github.com/simpletest/simpletest-demo"

# +-----------------------------+
# | ARGS                        |
# +-----------------------------+

#ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# +-----------------------------+
# | ENV                         |
# +-----------------------------+

ENV DEBIAN_FRONTEND=noninteractive
ENV DEBCONF_NONINTERACTIVE_SEEN=true

# +------------------------------+
# | PRE-REQUISITES/INIT PACKAGES |
# +------------------------------+

# avoid debconf delaying package configuration, since apt-utils is not installed
RUN apt-get update && \
    apt-get -y install --no-install-recommends apt-utils dialog sudo 2>&1

# Install packages
RUN apt-get -y install --no-install-recommends \
    build-essential autoconf \
    git zsh curl wget nano \
    # For PHP Extension: tidy
    libtidy-dev \
    # For PHP Extension: zip
    libzip-dev \
    # For PHP Extension: mbstring requires oniguruma
    libonig-dev \
    # for composer
    p7zip-full

# Cleanup
RUN apt-get autoremove -fy && \
    apt-get clean && \
    apt-get autoclean -y && \
    rm -rf /var/lib/apt/lists/*

# +------------------------------+
# | Install PHP Extensions       |
# +------------------------------+

RUN docker-php-ext-install opcache
RUN docker-php-ext-install zip
RUN docker-php-ext-install tidy
RUN docker-php-ext-install mbstring

# +------------------------------+
# | Install / Update Composer    | -> /usr/local/bin/composer
# +------------------------------+

RUN set -eux; \
    EXPECTED_SIGNATURE="$(curl -sS https://composer.github.io/installer.sig)"; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"; \
    if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then echo 'ERROR: Invalid installer signature' >&2; rm -f composer-setup.php; exit 1; fi; \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
    rm -f composer-setup.php; \
    composer --version; \
    composer self-update; \
    composer diagnose

# re-enable dialog mode for apt-get
ENV DEBIAN_FRONTEND=dialog
