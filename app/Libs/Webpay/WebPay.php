<?php namespace App\Libs;


class WebPay {
	protected $buyId;
	protected $amount;
	protected $sessionId;
	protected $urlReturn;
	protected $urlFinal;

	private $_webpay;

	protected $token;
	protected $url;
	protected $request;

	protected $error;

	public function __construct($init){
		require_once( app_path() . '/Libs/Webpay/libwebpay/webpay.php' );
		require_once( app_path() . '/Libs/Webpay/certificates/cert-normal.php');

		$this->config = new \Configuration();
		$this->sessionId = date('Ymdhis');

		$this->config->setCommerceCode(isset($init['comercio_codigo']) ? 
									$init['comercio_codigo'] : 
									$certificate['commerce_code']);

		$this->config->setEnvironment(isset($init['environment']) ? 
									$init['environment'] : 
									$certificate['environment']);

		$this->config->setPrivateKey(isset($init['private_key']) ?
									$init['private_key'] : 
									$certificate['private_key']);

		$this->config->setPublicCert(isset($init['public_cert']) ?
									$init['public_cert'] : 
									$certificate['public_cert']);

		$this->config->setWebpayCert(isset($init['webpay_cert']) ? 
									$init['webpay_cert'] : 
									$certificate['webpay_cert']);

		if(isset($init['buyId'])){
			$this->setBuyId($init['buyId']);
			$this->setAmount($init['amount']);
			$this->setUrlReturn($init['urlReturn']);
			$this->setUrlFinal($init['urlFinal']);
		}

		$this->_webpay = new \Webpay($this->config);
	}


	public function process(){
		$result = $this->_webpay
						->getNormalTransaction()
						->initTransaction(
								$this->getAmount(),
								$this->getBuyId(), 
								$this->getSessionId(), 
								$this->getUrlReturn(), 
								$this->getUrlFinal()
							);

		if(!empty($result->token) && isset($result->token)) {
			$this->token = $result->token;
			$this->url = $result->url;
		} else {
			$this->error = 'Error Token'.var_dump($result);
		}
	}

	public function getTransactionToken($token){
		return $this->_webpay->getNormalTransaction()->getTransactionResult($token);
	}

	public function getError(){
		return $this->error;
	}

	public function getToken(){
        return $this->token;
    }

    public function getUrl(){
        return $this->url;
    }

	public function getBuyId(){
        return $this->buyId;
    }

    public function setBuyId($buyId){
        $this->buyId = $buyId;
        return $this;
    }

    public function getAmount(){
        return $this->amount;
    }

    public function setAmount($amount){
        $this->amount = $amount;
        return $this;
    }

    public function getSessionId(){
        return $this->sessionId;
    }

    public function setSessionId($sessionId){
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getUrlReturn(){
        return $this->urlReturn;
    }

    public function setUrlReturn($urlReturn){
        $this->urlReturn = $urlReturn;
        return $this;
    }

    public function getUrlFinal(){
        return $this->urlFinal;
    }

    public function setUrlFinal($urlFinal){
        $this->urlFinal = $urlFinal;
        return $this;
    }

    public function getRequest(){
    	return $this->request;
    }
    public function setRequest($request){
    	$this->request = $request;
    }
} 