<?php
namespace aradiv\yii2\authclient\telegram;

use Yii;
use yii\base\Exception;

class Telegram extends yii\authclient\BaseClient {

    public $token;
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