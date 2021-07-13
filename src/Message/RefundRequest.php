<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        return [
            'amount' => $this->getAmountInteger(),
        ];
    }

    public function getRefundAction()
    {
        return $this->getParameter('refundAction');
    }

    public function setRefundAction(string $value)
    {
        return $this->setParameter('refundAction', $value);
    }

    public function sendData($data)
    {
        $transactionRef = $this->getTransactionReference();

        //get the transaction using the verifone API
        $httpResponse = $this->httpClient->post(
            $this->getEndpoint().'/transaction/'.$transactionRef.'/'.$this->getRefundAction(),
            [
                'X-APIKEY' => $this->getApiKey(),
                'Content-Type' => 'application/json',
            ],
            json_encode($data)
        )->send();

        return $this->response = new RefundResponse($this, $httpResponse->json());
    }
}
