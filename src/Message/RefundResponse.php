<?php

namespace Omnipay\Bpoint\Message;

class RefundResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        if (!parent::isSuccessful()) {
            return false;
        }
        return isset($this->data['responseCode']) && $this->data['responseCode'] == '0';
    }

    /**
     * Get transaction ID
     *
     * @return null|string A unique identifier for the transaction.
     */
    public function getTransactionId()
    {
        if (isset($this->data['txnNumber'])) {
            return $this->data['txnNumber'];
        }
    }

    /**
     * Get receiptNumber
     *
     * @return null|string A unique identifier for the transaction.
     */
    public function getReceiptNumber()
    {
        if (isset($this->data['receiptNumber'])) {
            return $this->data['receiptNumber'];
        }
    }
}