# Omnipay: BPoint

**BPoint v5 driver for the Omnipay PHP payment processing library**

BPoint v5 API: https://www.bpoint.com.au/developers/v5/index.htm#!#api

Currently only supports tokenized purchases with two available methods:

- createToken()
- purchase()

## Usage

```php
<?php
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

// Create a gateway for the Bpoint Gateway
// (routes to GatewayFactory::create)
/* @var \Omnipay\Bpoint\Gateway $gateway */
$gateway = Omnipay::create('Bpoint');

$gateway->setTestMode(true);
$gateway->setUsername('usernameValue');
$gateway->setPassword('passwordValue');
$gateway->setMerchantNumber('merchantIdValue');

// Tokenize a card
/* @var \Omnipay\Bpoint\Message\Response $response */
$response = $gateway->createToken([
    'card' => new CreditCard([
        'number' => '4987654321098769',
        'cvv' => '987',
        'expiryMonth' => '03',
        'expiryYear' => '2026',
        'firstName' => 'John',
        'lastName' => 'Doe',
    ]),
    'crn1' => '12345',
    'crn2' => '',
    'crn3' => null,
])->send();

if (!$response->isSuccessful()) {
    // handle errors
}

// Charge using a token
/* @var \Omnipay\Bpoint\Message\Response $response */
$response = $gateway->purchase([
    'card' => new CreditCard([
        'number' => $response->getToken(),
        'cvv' => '987',
        'expiryMonth' => '03',
        'expiryYear' => '2026',
        'firstName' => 'John',
        'lastName' => 'Doe',
    ]),
    'amount' => '50.00',
    'currency' => 'AUD',
    'description' => 'Merchant Reference',
    'crn1' => '12345',
    'crn2' => '',
    'crn3' => null,
])->send();
```

