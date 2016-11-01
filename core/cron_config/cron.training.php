<?php

$shellPath = getProjectPath('/shell');

return [

    /**
     *  每 30 分鐘
     *      - test google sheet and download to file
     */
    ['*/30 * * * *', "php {$shellPath}/test-google-sheet.php > /dev/null 2>&1"],

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
