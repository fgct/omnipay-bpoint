<?php

namespace Omnipay\Bpoint\Message;

use Omnipay\Bpoint\Traits\CommonParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Bpoint AuthKey Request.
 */
class CreateAuthKeyRequest extends AbstractRequest
{
    use CommonParametersTrait;

    /**
     * Get request data array to process a AuthKey.
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpointBase() . '/txns/authkeys';
    }

    /**
     * @return integer
     */
    public function getAuthKey()
    {
        return $this->getParameter('AuthKey');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setAuthKey($value)
    {
        return $this->setParameter('AuthKey', $value);
    }

    /**
     * @param       $data
     *
     * @return \Omnipay\Bpoint\Message\AuthKeyResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CreateAuthKeyResponse($this, $data);
    }
}
