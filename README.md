# omnipay-verifone-checkout

**Redirect gateway driver for Verifone's Checkout hosted service**

Omnipay implementation of Verifone's Checkout hosted gateway.

See [Verifone's Checkout documentation](https://sandbox.omni.verifone.cloud/docs/checkout_overview) for more details.

[![Build Status](https://travis-ci.org/digitickets/omnipay-verifone-checkout.png?branch=master)](https://travis-ci.org/digitickets/omnipay-verifone-checkout)
[![Latest Stable Version](https://poser.pugx.org/digitickets/omnipay-verifone-checkout/version.png)](https://packagist.org/packages/omnipay/omnipay-verifone-checkout)
[![Total Downloads](https://poser.pugx.org/digitickets/omnipay-verifone-checkout/d/total.png)](https://packagist.org/packages/digitickets/omnipay-verifone-checkout)

## Installation

This driver is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "digitickets/omnipay-verifone-checkout": "^1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## What's Included

This driver allows you to redirect the user to a Verifone Checkout page, after passing in customer details from your own forms and a redirect URL. 
Once the user has paid they will be redirected back to your redirect page. You can then confirm the payment through the driver.

It also supports refunds of partial and full amounts, and canceling of payment requests.

It only handles card payments.

It requires use of 3DSecure v2.

## What's Not Included

This driver does not handle any of the other card management operations, such as subscriptions (repeat payments), anything other than card payments, .

It does not support re-use of customer records at verifone, a new customer is created every time a payment comes in.

## Basic Usage

For general Omnipay usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

### Required Parameters

You must pass the following parameters into the driver when calling `purchase()`, `refund()` or `acceptNotification()`:

```
accountId: This is the Account ID from your Verifone account.
template: The URL pointing at your payment template (see Verifone documentation).
apiKey: The API from your Verifone account profile.
authenticatorId: You can request this from Verifone after signing up. 
dynamicDescriptor: This appears as a payment reference to the customer on their bank account. e.g. "BUS*Tickets"
```

Additional parameter for `acceptNotification()`:
```
requestInputs: This is the $_GET array from the query string from the redirect back to your site from Verifone. This contains the verifone transaction reference.
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you believe you have found a bug in this driver, please report it using the [GitHub issue tracker](https://github.com/digitickets/omnipay-verifone-checkout/issues),
or better yet, fork the library and submit a pull request.
