<?php
namespace aradiv\yii2\authclient\telegram;

use yii\authclient\OAuth2;

class Client extends OAuth2 {

    public $authUrl = 'https://telepass.me/oauth/authorize';
    public $tokenUrl = 'https://telepass.me/oauth/token';
    public $apiBaseUrl = 'https://telepass.me/api/';

    /**
     *
     */
    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = implode(' ', [
                'basic',
            ]);
        }
    }

    /**
     * @return array
     */
    public function initUserAttributes()
    {
        return $this->api('user', 'GET');
    }

    /**
     * @return string
     */
    protected function defaultTitle()
    {
        return "Telegram";
    }

    /**
     * @return string
     */
    protected function defaultName()
    {
        return "telegram";
    }




}
