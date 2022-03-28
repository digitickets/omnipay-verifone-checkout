<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

use Guzzle\Http\Exception\BadResponseException;

class RefundRequest extends AbstractRequest
{
    const REFUND_ACTION_REFUND = 'refund';
    const REFUND_ACTION_VOID = 'void_capture';

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

        // Refund or void the transaction using the verifone API
        try{
            $httpResponse = $this->httpClient->post(
                $this->getEndpoint().'/transaction/'.$transactionRef.'/'.$this->getRefundAction(),
                [
                    'X-APIKEY' => $this->getApiKey(),
                    'Content-Type' => 'application/json',
                ],
                json_encode($data)
            )->send();

        } catch (BadResponseException $e) {
            // On HTTP errors being returned, we still want to pass the response through, as Verifone passes through extra data in the body of errors,
            //  but only if it's returning json with a message field.
            $response = $e->getResponse();
            $data = json_decode($response->getBody(true), true);
            if(!empty($data["message"])){
                $httpResponse = $response;
            }else{
                // Unknown error
                throw $e;
            }
        }

        return $this->response = new RefundResponse($this, $httpResponse->json());
    }
}
