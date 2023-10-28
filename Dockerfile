FROM php:7.2-cli

RUN apt-get update -y \
    && apt-get install -y apt-utils \
    && apt-get install -y netcat \
    && apt-get install -y libxml2-dev \
    && docker-php-ext-install xml \
    && useradd -U -m -s /bin/bash note

WORKDIR /home/note

COPY login.php ./
COPY index.php ./
COPY content.php ./
COPY flag.txt ./
RUN mkdir notes

RUN chown -R note:note /home/note \
    && chmod 555 /home/note/ \
    && chmod 777 /home/note/notes/ \
    && chown root:root /home/note/flag.txt \
    && docker-php-ext-install xml \
    && docker-php-ext-install dom

USER note

EXPOSE 5000

CMD ["php", "-S", "0.0.0.0:5000", "-t", "/home/note"]
