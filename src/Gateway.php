<?php

namespace DigiTickets\OmnipayVerifoneCheckout;

use DigiTickets\OmnipayVerifoneCheckout\Message\CheckoutCreateCustomerRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\CheckoutCreateCustomerResponse;
use DigiTickets\OmnipayVerifoneCheckout\Message\CheckoutUrlRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\CheckoutUrlResponse;
use DigiTickets\OmnipayVerifoneCheckout\Message\CompletePurchaseRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\PurchaseRequest;
use DigiTickets\OmnipayVerifoneCheckout\Message\RefundRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

/**
 * @method RequestInterface authorize(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface capture(array $options = array())
 * @method RequestInterface void(array $options = array())
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = array())
 * @method RequestInterface completePurchase(array $options = array())
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'VerifoneCheckout';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [];
    }

    /**
     * @return string
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
     * @return string
     */
    public function getTemplate()
    {
        return $this->getParameter('template');
    }

    public function setTemplate(string $value)
    {
        return $this->setParameter('template', $value);
    }

    /**
     * @return string
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
     * @return string
     */
    public function getDynamicDescriptor()
    {
        return $this->getParameter('dynamicDescriptor');
    }

    public function setDynamicDescriptor(string $value)
    {
        return $this->setParameter('dynamicDescriptor', $value);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        $request = $this->createRequest(CheckoutCreateCustomerRequest::class, $parameters);
        /** @var CheckoutCreateCustomerResponse $response */
        $response = $request->send();

        $parameters['customerId'] = $response->getCustomerId();
        $request = $this->createRequest(CheckoutUrlRequest::class, $parameters);
        /** @var CheckoutUrlResponse $response */
        $response = $request->send();

        $parameters['checkoutUrl'] = $response->getCheckoutUrl();

        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|CompletePurchaseRequest
     */
    public function acceptNotification(array $parameters = [])
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|RefundRequest
     */
    public function refund(array $options = [])
    {
        // first we need to get the current status of the payment
        // we have to void the capture if it's in SETTLEMENT_REQUESTED status, instead of refund
        $request = $this->createRequest(CompletePurchaseRequest::class, $options);
        /** @var CheckoutCreateCustomerResponse $response */
        $response = $request->send();
        $status = $response->getData()['status'] ?? '';

        $options['refundAction'] = 'refund';
        if ($status === 'SETTLEMENT_REQUESTED') {
            //cancel the settlement request instead of refund
            $options['refundAction'] = 'void_capture';
        }

        return $this->createRequest(RefundRequest::class, $options);
    }
}
