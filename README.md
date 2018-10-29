[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Latest Stable Version](https://img.shields.io/packagist/v/aradiv/yii2-authclient-telegram.svg)](https://packagist.org/packages/aradiv/yii2-authclient-telegram)
[![Packagist](https://img.shields.io/packagist/dt/aradiv/yii2-authclient-telegram.svg)](https://packagist.org/packages/aradiv/yii2-authclient-telegram)


# Yii2 Authclient Telegram

Since Telegram doent offer a direct real oAuth method this authclient utilizes
[Telepass.me](https://telepass.me) until there is a native OAuth login with Telegram.

## Installation:

`
composer require --prefer-dist aradiv/yii2-authclient-telegram
`

##Usage:
in your config add:
```
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'telegram' => [
                    'class' => 'aradiv\yii2\authclient\telegram\Client,
                    'clientId' => '<yourTelepassClientId'>
                    'clientSecret' => '<yourTelepassClientSecret'>
                ]
            ],
        ],
        // ...
    ],
```

## Why I don't use the Telegram Login Widget
The [Telegram Login Widget](https://core.telegram.org/widgets/login) works fine standalone. 
Integrating it as an additional login method while maintaining compatibility to other modules that utilize
[Yii2 Authclient](https://github.com/yiisoft/yii2-authclient) isn't possible without doing all kinds special case 
handling and in some cases even change the entire user flow.

So to be able to 
1. Login with Telegram and 
1. keep using the modules I'm used to

I decided to relay on telepass.me for telegram login until there is an authclient compatible way for native telegram login.