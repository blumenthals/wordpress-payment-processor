<?php

/**
 * @package Fake Payment Processor
 * @version 1.0
 */
/*
Plugin Name: Payment Processor Library
Plugin URI: http://freesites.com/
Description: Payment Processor for Freesites.com
Author: Aria Stewart
Version: 1.0
*/

	class PaymentRequest {
		var $amount;
		var $address;
		var $name;
		var $email;
	}

	require(dirname(__FILE__)."/fake.php");
	
	abstract class PaymentProcessor {
		public abstract static function name();
		public abstract static function slug();
		public function process($request, $returnURL) {
			do_action('payment_processed', $request);
			do_action('payment_processed-'.$this->slug(), $request);
		}
	}


?>
