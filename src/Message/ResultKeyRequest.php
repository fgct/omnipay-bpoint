<?php

namespace Omnipay\Bpoint\Message;

use Omnipay\Bpoint\Traits\CommonParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Bpoint ResultKey Request.
 */
class ResultKeyRequest extends AbstractRequest
{
    use CommonParametersTrait;

    /**
     * Get request data array to process a ResultKey.
     *
     * @return array|mixed
     *
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('resultKey');

        if (!$this->getParameter('resultKey')) {
            throw new InvalidRequestException('You must pass a "resultKey" parameter.');
        }

        $resultKey = $this->getParameter('resultKey');
        // $resultKey->validate();

        $data = [];

        return $data;
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
     * @return \Omnipay\Bpoint\Message\ResultKeyResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new ResultKeyResponse($this, $data);
    }
}
