<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

class CheckoutUrlRequest extends AbstractRequest
{
    /**
     * @return array
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount');
        $this->validate('returnUrl');

        $data = [];
        $data['account'] = $this->getAccountId();
        $data['amount'] = $this->getAmountInteger();
        $data['customer'] = $this->getCustomerId();
        $data['merchant_reference'] = $this->getTransactionId();
        $data['template'] = $this->getTemplate();
        $data['return_url'] = $this->getReturnUrl();
        $data['configurations'] = [
            'card' => [
                'process_transaction' => true,
                'capture_now' => true,
                //dynamic_descriptor shows up on the customers bank statement as a reference e.g. BUS*Tickets
                'dynamic_descriptor' => $this->getDynamicDescriptor(),
                'threed_secure' => [
                    'enabled' => true,
                    'authenticator' => $this->getAuthenticatorId(),
                    'currency_code' => $this->getCurrency(),
                    /* M - Moto (Mail Order Telephone Order), P - Mobile Device, R - Retail (Physical Store), S - Computer Device, T - Tablet Device  */
                    'transaction_mode' => 'S',
                ],
            ],
        ];

        return $data;
    }

    public function getDynamicDescriptor()
    {
        return $this->getParameter('dynamicDescriptor');
    }

    public function setDynamicDescriptor($value)
    {
        return $this->setParameter('dynamicDescriptor', $value);
    }

    public function getTemplate()
    {
        return $this->getParameter('template');
    }

    public function setTemplate(string $value)
    {
        return $this->setParameter('template', $value);
    }

    public function getAuthenticatorId()
    {
        return $this->getParameter('authenticatorId');
    }

    public function setAuthenticatorId(string $value)
    {
        return $this->setParameter('authenticatorId', $value);
    }

    /**
     * @param mixed $data The data to send
     *
     * @return CheckoutUrlResponse
     */
    public function sendData($data)
    {
        $json = json_encode($data);
        $httpResponse = $this->httpClient->post(
            $this->getEndpoint().'/checkout/',
            [
                'X-APIKEY' => $this->getApiKey(),
                'Content-Type' => 'application/json',
            ],
            $json
        )->send();

        return $this->response = new CheckoutUrlResponse($this, $httpResponse->json());
    }
}
