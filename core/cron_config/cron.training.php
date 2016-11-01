<?php

$shellPath = getProjectPath('/shell');

return [

    /**
     *  每天早上
     *      - 依照 google sheet 的設定, 改變 facebook 的 狀態
     */
    ['10 * */1 * *', "php {$shellPath}/execute-facebook-active-pause-by-google-sheet.php > /dev/null 2>&1"],

];


# *    *    *    *    *  command to be executed
# ┬    ┬    ┬    ┬    ┬
# │    │    │    │    │
# │    │    │    │    │
# │    │    │    │    └───── day of week (0 - 7) (0 or 7 are Sunday, or use names)
# │    │    │    └────────── month (1 - 12)
# │    │    └─────────────── day of month (1 - 31)
# │    └──────────────────── hour (0 - 23)
# └───────────────────────── min (0 - 59)

#
# online tool
#   http://crontab.guru/
#
