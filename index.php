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
		var $success;
		public function PaymentRequest() {
			$this->success = false;
		}
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
			if(!$this->enabled) wp_die("This processor is not enabled");
			do_action('payment_processed', $request);
			do_action('payment_processed-'.$this->slug(), $request);
			if($request->success) {
				wp_redirect($returnURL);
			} else {
				wp_die("There was a problem processing your payment.");
			}
		}

		private static $processors = array();

		public static function getProcessors() {
			return self::$processors;
		}

		public static function addProcessor($p) {
			self::$processors[$p->slug()] = $p;
		}

		public static function getProcessor($slug) {
			return self::$processors[$slug];
		}

		private $enabled = false;
		static function enable() { $this->enabled = true; }

	}

	add_action('admin_init', function() {
		foreach(PaymentProcessor::getProcessors() as $p) {
			$sprefix = "payment_processor_".$p->slug();
			register_setting('payment_processor_options', "payment_processor_{$p->slug()}_enabled", 'boolval');
			add_settings_section("{$sprefix}_section", "Settings for {$p->name()}", function() { }, __FILE__);
			add_settings_field( "payment_processor_{$p->slug()}_enabled", "Enabled", function() use (&$p, $sprefix) {
				echo "<input type='checkbox' name='payment_processor_{$p->slug()}_enabled' value='1' class='code' ".checked(1, get_option("{$sprefix}_enabled"), false)." > Enable this processor";
			}, __FILE__, $sprefix."_section");
		}
	});

	function boolval($v) {
		return (boolean)$v;
	}

	add_action('admin_menu', function() {
		add_options_page('Payment Processor Options', 'Payment Processors', 'manage_options', __FILE__, function() { ?>
		<div class='wrap'>
		<h2>Payment Processors</h2>
		<p>Configure payment processor settings.</p>
		<form action="options.php" method="post">
			<?php settings_fields('payment_processor_options'); ?>
			<?php do_settings_sections(__FILE__); ?>
			<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</form>
		</div>
	<?php });
	});


?>
