<?php

$shellPath = getProjectPath('/shell');

return [

    /**
     *  每 30 分鐘
     *      - test google sheet and download to file
     */
    // ['*/30 * * * *', "php {$shellPath}/test-google-sheet.php > /dev/null 2>&1"],

];
