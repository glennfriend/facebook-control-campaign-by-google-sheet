#### Install & update
```sh
composer self-update
composer install
php autorun.php
```

### cron 執行方式
```
*/1 * * * * /usr/bin/php /專案路徑/cron.php > /dev/null 2>&1

php shell choose one
- /usr/bin/php
- /root/.phpbrew/php/php-7.0.0/bin/php
```