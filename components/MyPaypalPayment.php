<?php

namespace app\components;

use yii\base\Component;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class MyPaypalPayment extends Component
{
    public $client_id;
    public $client_secret;
    public $currency;
    private $apiContext;

    public function init()
    {
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->client_secret));
    }

    public function getContext()
    {
		return $this->apiContext;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}