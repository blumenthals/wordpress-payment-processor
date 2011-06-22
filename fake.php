<?php

add_action('init', function() {
	// FIXME: make it a preference to enable or disable this processor
	$p = new FakePaymentProcessor();
	if(get_option('payment_processor_fake')) $p->enable();
	PaymentProcessor::addProcessor($p);
});

class FakePaymentProcessor extends PaymentProcessor {
	static function name() { return 'Fake Processor'; }
	static function slug() { return 'fake'; }
	
	function process($request, $returnURL) {
		if(!$this->enabled) wp_die("This processor is not enabled");
		$request->success = true;
		parent::process($request, $returnURL);
	}
}

?>
