<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $liveEndpoint = 'https://omni.verifone.cloud/v1';
    protected $testEndpoint = 'https://sandbox.omni.verifone.cloud/v1';

    /**
     * @return string|null
     */
    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId(string $value)
    {
        return $this->setParameter('accountId', $value);
    }

    /**
     * @return string|null
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey(string $value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId(string $value)
    {
        return $this->setParameter('customerId', $value);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
