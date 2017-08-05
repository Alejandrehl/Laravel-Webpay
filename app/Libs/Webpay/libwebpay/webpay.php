<?php
require_once __DIR__ . '/soap/soap-wsse.php';
require_once __DIR__ . '/soap/soap-validation.php';
require_once __DIR__ . '/soap/soapclient.php';

include 'configuration.php';
include 'webpay-normal.php';

class Webpay {

	var $configuration, $webpayNormal;

	function __construct($params) {
		$this->configuration = $params;
	}

	public function getNormalTransaction() {
		if ($this->webpayNormal == null) {
			$this->webpayNormal = new WebPayNormal($this->configuration);
		}
		return $this->webpayNormal;
	}

}

class baseBean {

}

class getTransactionResult {

	var $tokenInput; //string

}

class getTransactionResultResponse {

	var $return; //transactionResultOutput

}