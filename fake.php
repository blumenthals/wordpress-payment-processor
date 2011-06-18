<?php

add_action('init', function() {
	// FIXME: make it a preference to enable or disable this processor
	PaymentProcessor::addProcessor(new FakePaymentProcessor());
});

class FakePaymentProcessor extends PaymentProcessor {
	static function name() { return 'Fake Processor'; }
	static function slug() { return 'fake'; }
	function process($request, $returnURL) {
		parent::process($request, $returnURL);
		wp_redirect($returnURL."&nonce=caFebaBE");
	}
}

?>
