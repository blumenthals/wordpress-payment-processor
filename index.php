<?php

/**
 * @package Payment Processor
 * @version 1.0
 */
/*
Plugin Name: Payment Processor Library
Plugin URI: http://freesites.com/
Description: Payment Processor for WordPress sites, providing payment processor settings to other WordPress plugins.
Author: Aria Stewart
Version: 1.0
*/

	define('PAYMENT_PROCESSOR', true);

	class PaymentRequest {
		var $amount;
		var $address;
		var $name;
		var $email;
	}

	require(dirname(__FILE__)."/fake.php");
	
	abstract class PaymentProcessor {
		public static function name() {
			return preg_replace('/([a-z])([A-Z])/', '\1 \2', get_called_class());
		}

		public static function slug() {
			return strtolower(get_called_class());
		}

		public function process($request, $returnURL) {
			do_action('payment_processed', $request);
			do_action('payment_processed-'.$this->slug(), $request);
		}

		private static $processors;

		public static function getProcessors() {
			return self::$processors;
		}

		public static function addProcessor($p) {
			if(!isset(self::$processors)) self::$processors = array();
			self::$processors[$p->slug()] = $p;
		}

		public static function getProcessor($slug) {
			return self::$processors[$slug];
		}
	}

?>
