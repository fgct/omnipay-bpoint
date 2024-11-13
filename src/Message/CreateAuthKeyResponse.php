<?php

namespace Omnipay\Bpoint\Message;

class CreateAuthKeyResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        if (!parent::isSuccessful()) {
            return false;
        }

        if (isset($this->data['authkey'])) {
            return true;
        }

        return false;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @link https://www.bpoint.com.au/developers/v3/index.htm#!#txnResponses
     *
     * @return string|null
     */
    public function getMessage()
    {
        if (!$this->isSuccessful()) {
            if (isset($this->data['message'])) {
                return $this->data['message'];
            }
        }

        return null;
    }

    /**
     * Get the error code from the response.
     *
     * Transaction responses 1-5 will return the two digit bank response code e.g. "38" (Allowable PIN tries exceeded).
     * All other error responses will return the BPoint error code.
     *
     * @link https://www.bpoint.com.au/developers/v3/index.htm#!#txnResponses
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getCode()
    {
        if (!$this->isSuccessful()) {
            if (isset($this->data['code'])) {
                return $this->data['code'];
            }
        }

        return null;
    }

    /**
     * Get auth key
     *
     * @return null|string A unique identifier for the transaction.
     */
    public function getAuthKey()
    {
        if (isset($this->data['authkey'])) {
            return $this->data['authkey'];
        }
    }
}