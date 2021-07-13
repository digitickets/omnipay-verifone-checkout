<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Test;

use DigiTickets\OmnipayVerifoneCheckout\Message\CheckoutUrlRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\CheckoutUrlResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class CheckoutUrlResponseTest extends TestCase
{
    public function testCreatingCheckoutUrl()
    {
        $request = Mockery::mock(CheckoutUrlRequest::class);
        $data = [
            '_id' => '123',
            'url' => 'http://google.com',
        ];

        $purchaseResponse = new CheckoutUrlResponse($request, $data);

        $this->assertTrue($purchaseResponse->isSuccessful());
        $this->assertFalse($purchaseResponse->isRedirect());
        $this->assertEquals('http://google.com', $purchaseResponse->getCheckoutUrl());
    }
}
