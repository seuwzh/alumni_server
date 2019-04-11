<?php
/**
 * Wafer php demo 配置文件
 */

$config = [
    'rootPath' => '',

    // 微信小程序 AppID
    'appId' => 'wx9160e3e42bba0357',

    // 微信小程序 AppSecret
    'appSecret' => '40dbb9ee7531818cc1063ad77ac78122',

    // 使用腾讯云代理登录
    'useQcloudLogin' => false,

    /**
     * MySQL 配置，用来存储 session 和用户信息
     * 若使用了腾讯云微信小程序解决方案
     * 开发环境下，MySQL 的初始密码为您的微信小程序 AppID
     */
    'mysql' => [
        'host' => '172.21.0.16',
        'port' => 3306,
        'user' => 'root',
        'db'   => 'cAuth',
        'pass' => 'Seu@Zimotion6102',
        'char' => 'utf8mb4'
    ],

    'cos' => [
        /**
         * 区域
         * 上海：cn-east
         * 广州：cn-sorth
         * 北京：cn-north
         * 广州二区：cn-south-2
         * 成都：cn-southwest
         * 新加坡：sg
         * @see https://www.qcloud.com/document/product/436/6224
         */
        'region' => 'cn-north',
        // Bucket 名称
        'fileBucket' => 'clab-1257046110',
        // 文件夹
        'uploadFolder' => ''
    ],

    // 微信登录态有效期
    'wxLoginExpires' => 7200,
    'wxMessageToken' => 'abcdefgh',

    
    'serverHost' => 'wx.wafersolution.com',
    'tunnelServerUrl' => 'http://tunnel.ws.qcloud.la',
    'tunnelSignatureKey' => '27fb7d1c161b7ca52d73cce0f1d833f9f5b5ec89',
      // 腾讯云相关配置可以查看云 API 密钥控制台：https://console.cloud.tencent.com/capi
    'qcloudAppId' => 1257046110,// 必须是数字
    'qcloudSecretId' => 'AKIDfCYihYBXHpGXcWurX6FGOPHxRkrrfHhw',
    'qcloudSecretKey' => 'x9B2hBTeeS4VkokV8aZO2UmtoY6TimjV',
    'networkTimeout' => 30000
];
