<?php

/**
 * Bpoint Response.
 */
namespace Omnipay\Bpoint\Message;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\Bpoint\Message\AbstractRequest;

/**
 * Bpoint Response.
 *
 * This is the response class for all Bpoint requests.
 *
 * @see \Omnipay\Bpoint\Gateway
 */
abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $arrayData = json_decode($data, true);

        if (is_array($arrayData)) {
            $this->data = $arrayData;
        } else {
            // TODO: handle error
        }
    }

    /**
     * Is the transaction successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        /** @var AbstractRequest $request */
        $request = $this->request;
        if ($request->getHttpResponseCode() >= 200 && $request->getHttpResponseCode() < 300) {
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
        $data = isset($this->data["txn"]) ? $this->data["txn"] : $this->data;
        if (isset($data["responseText"])) {
            return $data["responseText"];
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
        $data = isset($this->data["txn"]) ? $this->data["txn"] : $this->data;
        if (isset($data["responseCode"])) {
            return $data["responseCode"];
        }

        return null;
    }
}
