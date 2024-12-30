# fll-tournament-scorer public

Some setup notes:
* Requires a UNIX (tested on Debian 12) server with apache2, php7, mysql (e.g. https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mariadb-php-lamp-stack-on-debian-10). Php 8 works on the latest release (v8.x.x) only. Install php7 for older versions.
* Needs to be placed in the root server directory
* register.php, reset-password.php need to have reCaptcha keys added
* config.php needs to have the mysql database linked

mysql instructions:
```
>> CREATE DATABASE tournament;
>> USE tournament;
>> CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

`msmtp` needs to be configured for the webserver to send emails for 2FA registration. Gmail works if you disable modern authentication. See https://wiki.debian.org/msmtp. You can set for www-data or for the whole system.

Older versions can be found at https://github.com/sanjayseshan/tournament-scorer/releases

