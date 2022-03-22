<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

use Omnipay\Common\Message\AbstractResponse;

class RefundResponse extends AbstractResponse
{
    const SUCCESS_STATUSES = [
        'PENDING',
        'SETTLEMENT_CANCELLED',
    ];

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['status']) && in_array($this->data['status'], self::SUCCESS_STATUSES);
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->data['transaction'] ?? $this->data['_id'] ?? '';
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        $output = [
            $this->data['status'] ?? '',
            $this->data['status_reason'] ?? '',
            // This is only filled when there is an http error
            $this->data['message'] ?? '',
        ];

        return implode(
            ' - ',
            array_filter($output)
        );
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->data['status'] ?? $this->data['code'] ?? '';
    }
}
