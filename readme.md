### facebook-control-campaign-by-google-sheet

#### Your Google Sheet
- 建立你的 spreadsheet
- 公開這個 sheet
- 從網址可以得到 sheet file id
- sheet file id 包含 大小寫英文 & 數字
- sheet file id 類似 xxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

#### Environment Request
- [x] PHP 7
- [x] composer (https://getcomposer.org/)

#### Installation
```sh
cp example.config.php config.php
vi config.php
php autorun.php
```

#### Demo
```sh
php shell/test-google-sheet.php
```

#### Google Sheet status
```sh
A = Active
P = Pause
```