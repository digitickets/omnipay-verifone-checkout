<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

use Omnipay\Common\Message\AbstractResponse;

class CheckoutUrlResponse extends AbstractResponse
{
    /**
     * @return string|null
     */
    public function getCheckoutId()
    {
        $json = $this->getData();

        return $json['_id'];
    }

    /**
     * @return string|null
     */
    public function getCheckoutUrl()
    {
        $json = $this->getData();

        return $json['url'];
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $json = $this->getData();

        return $json &&
            is_array($json) &&
            !empty($json['_id']) &&
            !empty($json['url']);
    }
}
