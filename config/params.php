<?php
/**
 * @author donknap
 * @date 18-11-10 上午11:13
 */
return [
    // 产品信息
    'product'      => [
        'product_name'    => 'CareyShop商城框架系统(标准版)',
        'product_version' => '1.2.0',
        'build_version'   => '201704211135',
        'product_website' => 'http://www.careyshop.cn',
        'product_update'  => 'http://www.careyshop.cn/checkUpdate',
        'develop_team'    => 'think',
        'company_name'    => '宁波明达工作室',
        'company_website' => 'http://www.careyshop.cn',
    ],

    // 模块
    'module_group' => [
        'api'   => 'API',
        'admin' => '后台',
        'home'  => '前台',
    ],
    'clint_group' =>[
        'visitor' => [
            'value' => -1,
            'name'  => '游客组',
        ],
        'user'    => [
            'value' => 0,
            'name'  => '顾客组',
        ],
        'admin'   => [
            'value' => 1,
            'name'  => '管理组',
        ],
    ]
];
