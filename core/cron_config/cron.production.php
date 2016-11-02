<?php

$shellPath = getProjectPath('/shell');

return [

    /**
     *  每天早上
     *      - 依照 google sheet 的設定, 改變 facebook 的 狀態
     */
    ['10 0 * * *', "/root/.phpbrew/php/php-7.0.10/bin/php {$shellPath}/execute-facebook-active-pause-by-google-sheet.php > /dev/null 2>&1"],

];
