<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        return [
            'transaction_id' => $this->getTransactionReference(),
        ];
    }

    public function getRequestInputs()
    {
        return $this->getParameter('requestInputs');
    }

    public function setRequestInputs($value)
    {
        return $this->setParameter('requestInputs', $value);
    }

    /**
     * This is verifone's transaction id
     */
    public function getTransactionReference()
    {
        if ($this->getParameter('transactionReference')) {
            return $this->getParameter('transactionReference');
        }

        //this comes from the query string returned by verifone
        if (empty($this->getRequestInputs()) || empty($this->getRequestInputs()['transaction_id'])) {
            return '';
        }

        return $this->getRequestInputs()['transaction_id'];
    }

    public function setTransactionReference($value)
    {
        return $this->setParameter('transactionReference', $value);
    }

    public function getTransactionError()
    {
        if (empty($this->getRequestInputs()) || empty($this->getRequestInputs()['error'])) {
            return '';
        }

        return $this->getRequestInputs()['error'];
    }

    public function sendData($data)
    {
        //note the query string contains the transaction ID from verifone after the redirect back to us
        $transactionRef = $this->getTransactionReference();

        if ($transactionRef) {
            //get the transaction using the verifone API
            $httpResponse = $this->httpClient->get(
                $this->getEndpoint().'/transaction/'.$transactionRef,
                [
                    'X-APIKEY' => $this->getApiKey(),
                    'Content-Type' => 'application/json',
                ]
            )->send();

            return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
        } else {
            // if there is no transaction_id in the query string, the payment failed, and query string contains an error
            return $this->response = new CompletePurchaseResponse($this, ['error' => $this->getTransactionError()]);
        }
    }
}
