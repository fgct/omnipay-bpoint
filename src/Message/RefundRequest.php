<?php

namespace Omnipay\Bpoint\Message;

use Omnipay\Bpoint\Traits\CommonParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Refund Request.
 */
class RefundRequest extends AbstractRequest
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

        if ($amount === null) {
            throw new InvalidRequestException('You must pass a "amount" parameter.');
        }

        if (!$this->getParameter('originalTxnNumber')) {
            throw new InvalidRequestException('You must pass a "originalTxnNumber" parameter.');
        }
        $data = [
            "action" => 'Refund', // required "Unspecified" "Payment" "Refund" "UnmatchedRefund" "PreAuth" "Capture" "Reversal" "VerifyOnly"
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
            "originalTxnNumber" => $this->getOriginalTxnNumber(),
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
     * @param bool $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setOriginalTxnNumber($value)
    {
        return $this->setParameter('originalTxnNumber', $value);
    }

    /**
     * @return string
     */
    public function getOriginalTxnNumber()
    {
        return $this->getParameter('originalTxnNumber');
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
        return parent::getEndpointBase() . '/txns';
    }

    /**
     * @return integer
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
     * @return \Omnipay\Bpoint\Message\RefundResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new RefundResponse($this, $data);
    }
}
