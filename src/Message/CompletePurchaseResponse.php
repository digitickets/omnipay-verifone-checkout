<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    const SUCCESS_STATUSES = [
        'AUTHORIZED',
        'SETTLEMENT_REQUESTED',
        'SETTLEMENT_SUBMITTED',
        'SETTLEMENT_PARTIAL',
        'SETTLEMENT_COMPLETED',
    ];
    const PENDING_STATUSES = [
        'INITIATED',
        'PENDING',
    ];
    const FAILED_STATUSES = [
        'AUTHORIZATION_VOIDED',
        'SETTLEMENT_CANCELLED',
        'DECLINED',
        'FAILED',
        'UNKNOWN',
    ];

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['status']) && in_array($this->data['status'], self::SUCCESS_STATUSES);
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return !empty($this->data['error']) || !isset($this->data['status']) || in_array($this->data['status'], self::FAILED_STATUSES);
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return isset($this->data['status']) && in_array($this->data['status'], self::PENDING_STATUSES);
    }

    /**
     * this is our transaction ID
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return isset($this->data['merchant_reference']) ? $this->data['merchant_reference'] : null;
    }

    /**
     * this is verifone's transaction ID
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        return isset($this->data['_id']) ? $this->data['_id'] : null;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        if (!empty($this->data['error'])) {
            return $this->data['error'];
        }

        return isset($this->data['status']) ? $this->data['status'] : null;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return '';
    }
}
