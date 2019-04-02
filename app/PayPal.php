<?php

namespace App;

class PayPal{
	private $_apiContext;
	private $shopping_cart;
	private $_ClientId = 'AUJhC20Z-R2GdritxQQtM2grNZnDPK53guQQDnu24SRuobKqusMu_V6OIParz_19BWCFxzTKY_INYpeD';
	private $_ClientSecret = 'EHqRhWahUDGqs49LuNzV-PbBAeZ_vt7iDk7F_5b6bWFy_LwOQL_fTYAiKIfU7Ptx4NWJoNb7xOcWaR1l';

	public function __construct($shopping_cart){
		$this->_apiContext = \PaypalPayment::ApiContext($this->_ClientId, $this->_ClientSecret);

		$config = config("paypal_payment");
		$flatConfig = array_dot($config);

		$this->_apiContext->setConfig($flatConfig);

		$this->shopping_cart = $shopping_cart;
	}

	public function generate(){
		$payment = \PaypalPayment::payment()->setIntent("sale")
											->setPayer($this->payer())
											->setTransactions([$this->transaction()])
											->setRedirectUrls($this->redirectURLs());

		try{
			$payment->create($this->_apiContext);
		}catch(\Exception $ex){
			dd($ex);
			exit(1);
		}

		return $payment;

	}

	public function payer(){
		return \PaypalPayment::payer()->setPaymentMethod("paypal");
	}

	public function transaction(){
		return \PaypalPayment::transaction()
					->setAmount($this->amount())
					->setItemList($this->items())
					->setDescription("Tu compra en mi tienda")
					->setInvoiceNumber(uniqid());
	}

	public function items(){
		$items = [];

		$products = $this->shopping_cart->products()->get();

		foreach ($products as $product) {
			array_push($items, $product->paypalItem());
		}

		return \PaypalPayment::itemList()->setItems($items);
	}

	public function amount(){
		return \PaypalPayment::amount()->setCurrency("USD")
								->setTotal($this->shopping_cart->totalUSD());
	}

	public function redirectUrls(){
		$baseURL = url('/');
		return \PaypalPayment::redirectURLs()
									->setReturnURL("$baseURL/payments/store")
									->setCancelUrl("$baseURL/carrito");
	}

	public function execute($paymentId, $payerId){

		$payment = \PaypalPayment::getById($paymentId, $this->_apiContext);

		$execution = \PaypalPayment::PaymentExecution()->setPayerId($payerId);

		return $payment->execute($execution, $this->_apiContext);

	}


}