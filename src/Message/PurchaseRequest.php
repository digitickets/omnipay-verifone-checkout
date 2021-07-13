<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

/**
 * returns a redirect url sending customer to verifone Checkout page
 */
class PurchaseRequest extends AbstractRequest
{
    public function getCheckoutUrl()
    {
        return $this->getParameter('checkoutUrl');
    }

    public function setCheckoutUrl(string $value)
    {
        return $this->setParameter('checkoutUrl', $value);
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function getEndpoint()
    {
        return $this->getCheckoutUrl();
    }

    public function getData()
    {
        return [];
    }
}
