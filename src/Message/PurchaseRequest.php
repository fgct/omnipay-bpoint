<?php

namespace Omnipay\Bpoint\Message;

use Omnipay\Bpoint\Traits\CommonParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Bpoint Purchase Request.
 */
class PurchaseRequest extends AbstractRequest
{
    use CommonParametersTrait;

    /**
     * Get request data array to process a purchase.
     *
     * @return array|mixed
     *
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency');

        if (!$this->getParameter('card')) {
            throw new InvalidRequestException('You must pass a "card" parameter.');
        }

        /** @var \OmniPay\Common\CreditCard $card */
        $card = $this->getParameter('card');
        $card->validate();

        $payload = [
            'testMode' => $this->getTestMode(),
        ];

        $payload['action'] = 'payment';
        $payload['amount'] = $this->getAmountInteger();
        if ($this->getAmountSurcharge()) {
            $payload['amountSurcharge'] = $this->getAmountSurcharge();
        }
        $payload['currency'] = $this->getCurrency();
        if ($this->getDescription()) {
            $payload['merchantReference'] = $this->filter($this->getDescription());
        }
        $payload['crn1'] = $this->filter($this->getCrn1());
        if ($this->getCrn2()) {
            $payload['crn2'] = $this->filter($this->getCrn2());
        }
        if ($this->getCrn3()) {
            $payload['crn3'] = $this->filter($this->getCrn3());
        }
        $payload['storeCard'] = false;
        $payload['subType'] = 'Single';
        $payload['Type'] = 'Internet';
        $payload['cardDetails'] = [
            'name' => $card->getBillingName(),
            'number' => $card->getNumber(),
            'cvn' => $card->getCvv(),
            'expiry' => [
                // add leading zero to the $card->getExpiryMonth()
                'month' => str_pad($card->getExpiryMonth(), 2, '0', STR_PAD_LEFT),
                // get last two digits of the $card->getExpiryYear()
                'year' => substr($card->getExpiryYear(), -2),
            ],
        ];

        if ($this->getBillerCode()) {
            $payload['billerCode'] = $this->filter($this->getBillerCode());
        }

        // Currently unsupported optional params
        // $payload['amountOriginal'] = null; // Base transaction amount in the lowest denomination for the currency (without surcharge)
        // $payload['emailAddress'] = null;
        // $payload['originalTxnNumber'] = null;
        // $payload['statementDescriptor'] = [];

        return $payload;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpointBase() . '/txns';
    }

    /**
     * @return integer
     */
    public function getAmountSurcharge()
    {
        return $this->getParameter('amountSurcharge');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setAmountSurcharge($value)
    {
        return $this->setParameter('amountSurcharge', $value);
    }

    /**
     * @param       $data
     *
     * @return \Omnipay\Bpoint\Message\PurchaseResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
