<?php

namespace Omnipay\Bpoint\Traits;

trait CommonParametersTrait
{
    /**
     * @return mixed
     */
    public function getCrn1()
    {
        return $this->getParameter('crn1');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setCrn1($value)
    {
        return $this->setParameter('crn1', $value);
    }

    /**
     * @return mixed
     */
    public function getCrn2()
    {
        return $this->getParameter('crn2');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setCrn2($value)
    {
        return $this->setParameter('crn2', $value);
    }

    /**
     * @return mixed
     */
    public function getCrn3()
    {
        return $this->getParameter('crn3');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setCrn3($value)
    {
        return $this->setParameter('crn3', $value);
    }

    /**
     * @return string
     */
    public function getBillerCode()
    {
        return $this->getParameter('billerCode');
    }

    /**
     * @param $value
     *
     * @return AbstractRequest provides a fluent interface.
     */
    public function setBillerCode($value)
    {
        return $this->setParameter('billerCode', $value);
    }

    /**
     * @return string
     */
    public function getResultKey()
    {
        return $this->getParameter('resultKey');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Bpoint\Message\AbstractRequest provides a fluent interface.
     */
    public function setResultKey($value)
    {
        return $this->setParameter('resultKey', $value);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->getParameter('currency') ?: 'AUD';
    }
}
