### 1 | PREPARE
Create .env file.
```dotenv
APP_NAME="Ubuntu Test"
CONNECT_URL=https://localhost/api
```

### 2 | INSTALL
Run composer install.
```dotenv
composer install
```

### 3 | SCHEDULE
Add schedule to run.
```
* * * * * php /path-to-your-project/your-app-name schedule:run >> /dev/null 2>&1
```
