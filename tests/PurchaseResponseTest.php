<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Test;

use DigiTickets\OmnipayVerifoneCheckout\Message\PurchaseRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\PurchaseResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    public function testCreatingPurchaseRedirect()
    {
        $request = Mockery::mock(PurchaseRequest::class);
        $request->shouldReceive('getEndpoint')->andReturn('http://google.com');

        $purchaseResponse = new PurchaseResponse($request, []);

        $this->assertFalse($purchaseResponse->isSuccessful());
        $this->assertTrue($purchaseResponse->isRedirect());
        $this->assertEquals('http://google.com', $purchaseResponse->getRedirectUrl());
        $this->assertEquals('GET', $purchaseResponse->getRedirectMethod());
    }
}
