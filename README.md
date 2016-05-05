# yiidreamteam\smspilot\Api

PHP class for working with [smspilot.ru](http://smspilot.ru) api by [Yii Dream Team](http://yiidreamteam.com/).

## Installation ##

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

    php composer.phar require --prefer-dist yii-dream-team/smspilot "*"

or add

    "yii-dream-team/smspilot": "*"

to the `require` section of your composer.json.

## Usage

Authorization:

    $api = new \yiidreamteam\smspilot\Api($apiId);

Sending text message:

    $api->send('79112223344', 'Text message');
    $api->send('79112223344', 'Text message', 'Sender', 'messageId');
    
## Licence ##
    
MIT

## Links

* [smspilot.ru service](http://smspilot.ru)
* [Official site](http://yiidreamteam.com/php/smspilot)
* [Source code on GitHub](https://github.com/yii-dream-team/smspilot)
* [Composer package on Packagist](https://packagist.org/packages/yii-dream-team/smsru)