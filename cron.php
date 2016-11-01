<?php

    use Bridge\Log;

    require_once __DIR__ . '/core/bootstrap.php';

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------
    $path = getProjectPath('/core/cron_config');
    if ('production' === conf('app.env')) {
        $config = include($path . '/cron.production.php');
    }
    elseif ('training' === conf('app.env')) {
        $config = include($path . '/cron.training.php');
    }
    else {
        echo 'cron env error';
        exit;
    }

    /**
     *
     */
    $runSchedule = function(Array $config)
    {
        foreach ($config as $items) {
            list($schedule, $shell) = $items;
            $cron = Cron\CronExpression::factory($schedule);
            if (!$cron->isDue()) {
                continue;
            }

            Log::cron($shell);
            exec($shell);
        }

    };
    $runSchedule($config);

    //
    exit;

