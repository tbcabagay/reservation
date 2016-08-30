<?php

namespace app\components;

use yii\base\Component;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class MyPayPalPayment extends Component {
    public $client_id;
    public $client_secret;
    private $apiContext;

    public function init() { 
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->client_secret));
    }

    public function getContext() {
		return $this->apiContext;
    }
}