<?php

namespace Omnipay\Bpoint\Message;

use Omnipay\Bpoint\Traits\CommonParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Bpoint AuthKey Request.
 */
class AttachTxnDetailsRequest extends AbstractRequest
{
    use CommonParametersTrait;

    /**
     * Get request data array to process a AuthKey.
     *
     * @return array
     */
    public function getData()
    {
        $amount = $this->getParameter('amount');
        if (!$this->getParameter('auth_key')) {
            throw new InvalidRequestException('You must pass a "auth_key" parameter.');
        }
        if ($amount === null) {
            throw new InvalidRequestException('You must pass a "amount" parameter.');
        }

        $data = [
            "action" => $this->getAction(), // required "Unspecified" "Payment" "Refund" "UnmatchedRefund" "PreAuth" "Capture" "Reversal" "VerifyOnly"
            "type" => "Internet", // required "Unspecified" "Internet" "CallCentre" "CardPresent" "ECommerce" "Ivr" "MailOrder" "TelephoneOrder"
            "subType" => "Single", // required "Unspecified" "Single" "Recurring"
            "amount" => $amount, // required int
            "billerCode" => $this->getBillerCode(),
            "crn1" => $this->getCrn1(),
            "crn2" => $this->getCrn2(),
            "crn3" => $this->getCrn3(),
            "merchantReference" => $this->getMerchantReference(), // Reference that is for internal use only.
            "currency" => $this->getCurrency(), // required
            "bypass3ds" => $this->getBypass3ds(),
            "tokenisationMode" => "Default", // "Default" "None" "OptIn" "All"
            "emailAddress" => $this->getEmailAddress(), // Customer's email address
            "storeCard" => $this->getStoreCard(),
            "testMode" => $this->getTestMode()
        ];

        return $data;
    }

    /**
     * @return bool
     */
    public function getAction()
    {
        return $this->getParameter('action') ?: 'Payment';
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setAction($value)
    {
        return $this->setParameter('action', $value);
    }

    /**
     * @return bool
     */
    public function getBypass3ds()
    {
        return $this->getParameter('bypass3ds') === true;
    }

    /**
     * @param bool $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setBypass3ds($value)
    {
        return $this->setParameter('bypass3ds', $value);
    }

    /**
     * @return bool
     */
    public function getStoreCard()
    {
        return $this->getParameter('storeCard') === true;
    }

    /**
     * @param bool $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setStoreCard($value)
    {
        return $this->setParameter('storeCard', $value);
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->getParameter('emailAddress');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setEmailAddress($value)
    {
        return $this->setParameter('storeCard', $value);
    }

    /**
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->getParameter('merchantReference');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setMerchantReference($value)
    {
        return $this->setParameter('merchantReference', $value);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpointBase() . '/txns/authkeys/'.$this->getAuthKey().'/txn-details';
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->getParameter('auth_key');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setAuthKey($value)
    {
        return $this->setParameter('auth_key', $value);
    }

    /**
     * @param       $data
     *
     * @return \Omnipay\Bpoint\Message\AttachTxnDetails
     */
    protected function createResponse($data)
    {
        return $this->response = new AttachTxnDetailsResponse($this, $data);
    }
    
    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'PUT';
    }
}
