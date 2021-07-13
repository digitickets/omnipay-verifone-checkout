<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Test;

use DigiTickets\OmnipayVerifoneCheckout\Message\CheckoutCreateCustomerRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\CheckoutCreateCustomerResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class CheckoutCreateCustomerResponseTest extends TestCase
{
    public function testCreatingCustomer()
    {
        $request = Mockery::mock(CheckoutCreateCustomerRequest::class);
        $data = [
            '_id' => '123',
        ];

        $purchaseResponse = new CheckoutCreateCustomerResponse($request, $data);

        $this->assertTrue($purchaseResponse->isSuccessful());
        $this->assertFalse($purchaseResponse->isRedirect());
        $this->assertEquals('123', $purchaseResponse->getCustomerId());
    }
}
