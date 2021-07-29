<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

use Omnipay\Common\Message\AbstractResponse;

class CheckoutCreateCustomerResponse extends AbstractResponse
{
    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        $json = $this->getData();

        return $json['_id'];
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $json = $this->getData();

        return $json && is_array($json) && !empty($json['_id']);
    }
}
