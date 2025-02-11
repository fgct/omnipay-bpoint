<?php

/**
 * Bpoint Gateway.
 */
namespace Omnipay\Bpoint;

use Omnipay\Bpoint\Message\AttachTxnDetailsRequest;
use Omnipay\Bpoint\Message\CreateAuthKeyRequest;
use Omnipay\Bpoint\Message\PurchaseRequest;
use Omnipay\Bpoint\Message\CreateTokenRequest;
use Omnipay\Bpoint\Message\ProcessAuthKeyRequest;
use Omnipay\Bpoint\Message\RefundRequest;
use Omnipay\Bpoint\Message\ResultKeyRequest;
use Omnipay\Common\AbstractGateway;

/**
 * Bpoint Gateway.
 *
 * Example:
 *
 * <code>
 *   // Create a gateway for the Bpoint Gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('Bpoint');
 *   $gateway->setUsername('usernameValue');
 *   $gateway->setPassword('passwordValue');
 *   $gateway->setMerchantId('merchantIdValue');
 *
 *   // Tokenize a card
 *   $response = $gateway->createToken([
 *       'card' => new CreditCard([...]),
 *       'crn1' => '12345',
 *       'crn2' => '',
 *       'crn3' => null,
 *   ])->send();
 *
 *   // Charge using a token
 *   $gateway->purchase([
 *       'card' => new CreditCard([
 *           'number' => $response->getToken(),
 *           ...
 *       ]),
 *       'amount' => '50.00',
 *       'currency' => 'AUD',
 *       'description' => 'Merchant Reference',
 *       'crn1' => '12345',
 *       'crn2' => '',
 *       'crn3' => null,
 *   ])->send();
 *
 * </code>
 *
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())         (Optional method)
 *         Authorize an amount on the customers card
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array()) (Optional method)
 *         Handle return from off-site gateways after authorization
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())           (Optional method)
 *         Capture an amount you have previously authorized
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())  (Optional method)
 *         Handle return from off-site gateways after purchase
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())            (Optional method)
 *         Refund an already processed transaction
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())              (Optional method)
 *         Generally can only be called up to 24 hours after submitting a transaction
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())        (Optional method)
 *         The returned response object includes a cardReference, which can be used for future transactions
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())        (Optional method)
 *         Update a stored card
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())        (Optional method)
 *         Delete a stored card
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Bpoint';
    }

    /**
     * Get the gateway parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'endpointBase' => 'https://www.bpoint.com.au/rest/v5',
            'username' => '',
            'password' => '',
            'merchantNumber' => '',
        );
    }

    /**
     * @return string
     */
    public function getEndpointBase()
    {
        return $this->getParameter('endpointBase');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Bpoint\Gateway
     */
    public function setEndpointBase($value)
    {
        return $this->setParameter('endpointBase', $value);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Bpoint\Gateway
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return string
     */
    public function getMerchantNumber()
    {
        return $this->getParameter('merchantNumber');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Bpoint\Gateway
     */
    public function setMerchantNumber($value)
    {
        return $this->setParameter('merchantNumber', $value);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Bpoint\Gateway
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Purchase request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Bpoint\Message\PurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Purchase request using auth key
     *
     * @param string $auth_key
     * @param array $parameters
     *
     * @return \Omnipay\Bpoint\Message\AttachTxnDetailsRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function attachTxnDetails(string $auth_key, array $parameters = array())
    {
        return $this->createRequest(AttachTxnDetailsRequest::class, array_merge($parameters, ['auth_key' => $auth_key]));
    }

    /**
     * Create auth key
     *
     * @return \Omnipay\Bpoint\Message\CreateAuthKeyRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function createAuthKey()
    {
        /** @var \Omnipay\Bpoint\Message\CreateAuthKeyResponse $response */
        return $this->createRequest(CreateAuthKeyRequest::class, []);
    }

    /**
     * Process transaction with auth key
     *
     * @param string $authKey
     *
     * @return \Omnipay\Bpoint\Message\ProcessAuthKeyRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function processAuthKey(string $auth_key, array $parameters = array())
    {
        return $this->createRequest(ProcessAuthKeyRequest::class, array_merge($parameters, ['auth_key' => $auth_key]));
    }

    /**
     * Get result key details.
     *
     * @param string $resultKey
     *
     * @return \Omnipay\Bpoint\Message\ResultKeyRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function getResultKey(string $resultKey)
    {
        return $this->createRequest(ResultKeyRequest::class, ['resultKey' => $resultKey]);
    }

    /**
     * Create token request.
     *
     * @param array $parameters parameters to be passed in to the TokenRequest.
     *
     * @return \Omnipay\Bpoint\Message\CreateTokenRequest|\Omnipay\Common\Message\AbstractRequest The create token request.
     */
    public function createToken(array $parameters = array())
    {
        return $this->createRequest(CreateTokenRequest::class, $parameters);
    }

    /**
     * Refund request
     *
     * @param array $parameters
     *
     * @return \Omnipay\Bpoint\Message\RefundRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * Supports AcceptNotification
     *
     * @return boolean True if this gateway supports the acceptNotification() method
     */
    public function acceptNotification()
    {
        return;
    }

    /**
     * Supports Fetch Transaction
     *
     * @return boolean True if this gateway supports the fetchTransaction() method
     */
    public function fetchTransaction()
    {
        return;
    }
}
