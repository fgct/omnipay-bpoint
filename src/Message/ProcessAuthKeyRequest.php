<?php

namespace Omnipay\Bpoint\Message;

use Omnipay\Bpoint\Traits\CommonParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Bpoint AuthKey Request.
 */
class ProcessAuthKeyRequest extends AbstractRequest
{
    use CommonParametersTrait;

    /**
     * Get request data array to process a AuthKey.
     *
     * @return array
     */
    public function getData()
    {
        $data = [
            // 'webhook' => [
            //     'url' => '',
            //     'version' => 'POST',
            // ],
            // 'surcharge' => [
            //     'calculate' => false,
            //     'amount' => $amount,
            // ],
            'updateToken' => true,
            // 'TxnDetails' => [
            //     'txnType' => '0',
            //     'txnSource' => '0',
            //     'amount' => $amount,
            //     'currency' => 'AUD',
            // ],
        ];

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpointBase() . '/txns/authkeys/'.$this->getAuthKey().'/process';
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
     * @return \Omnipay\Bpoint\Message\AuthKeyResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new ProcessAuthKeyResponse($this, $data);
    }
}
