<?php
namespace aradiv\yii2\authclient\telegram;

use Yii;
use yii\authclient\OAuth1;
use yii\authclient\OAuth2;
use yii\authclient\OAuthToken;
use yii\authclient\OpenId;
use yii\base\Exception;
use yii\authclient\BaseClient;
use yii\helpers\Url;

class Telegram extends OAuth2 {

    public $token;
    public $botid;
    public $maxTimeout = 60*60;

    public function initUserAttributes(){
        $getParams = Yii::$app->request->get();
        $hash = $getParams['hash'];
        unset($getParams['hash']);
        $userdata = $this->prepareCheckData($getParams);
        if(time()-$getParams['auth_date'] > $this->maxTimeout) {
            throw new Exception('data is outdated');
        }
        if($this->checkData($hash, $userdata)){
            return $getParams;
        }else{
            throw new Exception('Data is NOT from Telegram');
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function defaultName()
    {
        return 'telegram';
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultTitle()
    {
        return 'Telegram';
    }

    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
        ];
    }

    public function buildAuthUrl(array $params = [])
    {
        return 
"https://oauth.telegram.org/auth?bot_id=".$this->botid."&origin=".urlencode(Url::base(true));
    }

    private function checkData($hash,$userdata){
        $secret_key = hash('sha256', $this->token, true);
        $checkhash = hash_hmac('sha256',$userdata,$secret_key);
        if( strcmp($hash,$checkhash) !== 0 ) {
            return false;
        }
        return true;
    }

    private function prepareCheckData($params){
        foreach ($params as $key => $value) {
            $arr[] = $key . '=' . $value;
        }
        sort($arr);
        return implode("\n", $arr);
    }
}
