<?php

namespace Omnipay\Bpoint\Message;

class ProcessAuthKeyResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        if (!parent::isSuccessful()) {
            return false;
        }

        return isset($this->data['txn'], $this->data['txn']['responseCode']) && $this->data['txn']['responseCode'] == '0';
    }

    /**
     * Get txn
     *
     * @return array
     */
    public function getTxn()
    {
        if (isset($this->data['txn'])) {
            return $this->data['txn'];
        }
    }

    /**
     * Get transaction ID
     *
     * @return null|string A unique identifier for the transaction.
     */
    public function getTransactionId()
    {
        if (isset($this->data['txn']['txnNumber'])) {
            return $this->data['txn']['txnNumber'];
        }
    }

    /**
     * Get receiptNumber
     *
     * @return null|string A unique identifier for the transaction.
     */
    public function getReceiptNumber()
    {
        if (isset($this->data['txn']['receiptNumber'])) {
            return $this->data['txn']['receiptNumber'];
        }
    }
}