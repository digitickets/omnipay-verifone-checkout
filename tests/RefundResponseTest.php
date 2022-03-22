<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Test;

use DigiTickets\OmnipayVerifoneCheckout\Message\RefundRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\RefundResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class RefundResponseTest extends TestCase
{
    /**
     * @dataProvider creationProvider
     */
    public function testCreatingRefund(
        array $data,
        bool $expectedSuccess,
        string $expectedMessage,
        string $transactionRef
    ) {
        $request = Mockery::mock(RefundRequest::class);

        $purchaseResponse = new RefundResponse($request, $data);

        $this->assertEquals($expectedSuccess, $purchaseResponse->isSuccessful());
        $this->assertEquals($expectedMessage, $purchaseResponse->getMessage());
        $this->assertEquals($transactionRef, $purchaseResponse->getTransactionReference());
    }

    /**
     * @return array
     */
    public function creationProvider()
    {
        return [
            'success' => [
                ['_id' => '123', 'status' => 'PENDING', 'status_reason' => ''],
                true,
                'PENDING',
                '123',
            ],
            'failed' => [
                ['_id' => '123', 'status' => 'FAILED', 'status_reason' => 'failed reason'],
                false,
                'FAILED - failed reason',
                '123',
            ],
            'http error' => [
                ['_id' => '123', 'message' => 'Bad request', 'code' => '400'],
                false,
                'Bad request',
                '123',
            ],
        ];
    }
}
