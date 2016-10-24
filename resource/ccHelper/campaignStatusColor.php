<?php

/**
 *  對於 campaign status 為啟用時, 顯示醒目的顏色
 */
function ccHelper_campaignStatusColor($show, $status)
{
    switch (strtolower((string)$status)) {
        case '1':
        case 'on':
        case 'active':
            return '<span style="color: red;">'. $show .'</span>';
            break;
        default:
            return $show;
    }
}
