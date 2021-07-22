<?php

namespace DigiTickets\OmnipayVerifoneCheckout\Message;

class CheckoutCreateCustomerRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $creditCard = $this->getCard();
        $data = [
            'billing' => [
                'first_name' => $creditCard->getFirstName(),
                'last_name' => $creditCard->getLastName(),
                'address_1' => $creditCard->getAddress1(),
                'address_2' => $creditCard->getAddress2(),
                'phone' => $creditCard->getBillingPhone(),
                'postal_code' => $creditCard->getPostcode(),
                'country_code' => $creditCard->getCountry(),
                'city' => $creditCard->getCity(),
            ],
            'email_address' => $creditCard->getEmail(),
            'gender' => $creditCard->getGender(),
            'title' => $creditCard->getTitle(),
            'phone' => $creditCard->getPhone(),
            'company_name' => $creditCard->getCompany(),
        ];

        if ($creditCard->getState()) {
            $data['billing']['state'] = $creditCard->getState();
        }

        return array_filter($data);
    }

    /**
     * @param mixed $data The data to send
     *
     * @return CheckoutCreateCustomerResponse
     */
    public function sendData($data)
    {
        $json = json_encode($data);
        $httpResponse = $this->httpClient->post(
            $this->getEndpoint().'/customer/',
            [
                'X-APIKEY' => $this->getApiKey(),
                'Content-Type' => 'application/json',
            ],
            $json
        )->send();

        return $this->response = new CheckoutCreateCustomerResponse($this, $httpResponse->json());
    }
}
