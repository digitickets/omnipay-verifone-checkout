<?php

namespace DigiTickets\StripeTests;

use DigiTickets\OmnipayVerifoneCheckout\Message\CompletePurchaseRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\CompletePurchaseResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    /**
     * @dataProvider creationProvider
     */
    public function testCreatingCompletePurchaseResponse(
        array $data,
        bool $expectedSuccess,
        bool $expectedCancelled,
        string $expectedMessage,
        string $expectedReference = null
    ) {
        $request = Mockery::mock(CompletePurchaseRequest::class);

        $response = new CompletePurchaseResponse($request, $data);

        $this->assertEquals($expectedSuccess, $response->isSuccessful());
        $this->assertEquals($expectedCancelled, $response->isCancelled());
        $this->assertEquals($expectedMessage, $response->getMessage());
        $this->assertEquals($expectedReference, $response->getTransactionReference());
    }

    /**
     * @return array
     */
    public function creationProvider()
    {
        return [
            'success' => [
                ['_id' => '123', 'status' => 'SETTLEMENT_REQUESTED'],
                true,
                false,
                'SETTLEMENT_REQUESTED',
                '123',
            ],
            'declined' => [
                ['status' => 'DECLINED'],
                false,
                true,
                'DECLINED',
                '',
            ],
            'error' => [
                ['error' => 'test error'],
                false,
                true,
                'test error',
                '',
            ],
        ];
    }
}
