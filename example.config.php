<?php
/**
 *  這裡的設定值, 將會覆蓋 core/config/ 下相同名稱的值
 */
return [
    'app' => [
        // 不論在任何情況下, 正式的環境都必須使用 'production' 為 env 的值
        // 測試環境請使用 'training'
        'env' => 'production',
    ],
    'google' => [
        'sheet'  => [
            'file_id' => 'xxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        ]
    ],
    'facebook' => [
        'app' => [
            'id'     => 'xxxxxxxxxxxxxxx',
            'secret' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        ],
    ],
];
