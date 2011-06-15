<?php

add_action('init', function() {
	global $PAYMENT_PROCESSORS;
	if(!isset($PAYMENT_PROCESSORS)) {
		$PAYMENT_PROCESSORS = array();
	}

	// FIXME: make it a preference to enable or disable this processor
	$PAYMENT_PROCESSORS['fake'] = 'FakePaymentProcessor';
});

class FakePaymentProcessor extends PaymentProcessor {
	static function name() { return 'Fake Processor'; }
	static function slug() { return 'fake'; }
	function process($request, $returnURL) {
		parent::process($request, $returnURL);
		wp_redirect($returnURL."?nonce=caFebaBE");
	}
}

?>
