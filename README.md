### 1 | PHP 8.5
Cleanup previous version (if needed)
```shell
sudo apt-get purge php8.*
sudo apt-get autoclean
sudo apt-get autoremove
```

Install PHP 8.5.
```shell
sudo add-apt-repository ppa:ondrej/php

sudo apt install --no-install-recommends php8.5
sudo apt-get install -y php8.5-dom

php8.5-curl php8.5-gd php8.5-zip php8.5-mysql php8.5-simplexml 
```

### 2 | PREPARE
Create .env file.
```dotenv
APP_NAME="Ubuntu Test"
CONNECT_URL=https://localhost/api
```

### 3 | INSTALL
Run composer install.
```dotenv
composer install
```

### 4 | SCHEDULE
Add schedule to run.
```
* * * * * php /var/www/server-health schedule:run >> /dev/null 2>&1
```
