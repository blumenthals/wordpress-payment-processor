Payment Processor Plugin
========================

Provides payment processors and settings screens for other plugins to use to process payments.

API
---

`PaymentProcessor::addProcessor($processor)` -- ties an instance to a slug

`aPaymentProcessor->process($request, $responseURL)` -- TODO: make it take a function instead of a URL. Do the actual processing, get the result.

`PaymentProcessor::getProcessor($slug)` -- Get an instance by slug

`PaymentProcessor::getProcessors()` -- get the list of registered processors for user selection
