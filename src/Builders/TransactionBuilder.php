<?php

namespace GlobalPayments\Api\Builders;

use GlobalPayments\Api\Builders\BaseBuilder\Validations;
use GlobalPayments\Api\Entities\Enums\TransactionModifier;
use GlobalPayments\Api\Entities\Exceptions\ArgumentException;
use GlobalPayments\Api\Entities\Transaction;

abstract class TransactionBuilder extends BaseBuilder
{
    /**
     * Request transaction type
     *
     * @internal
     * @var TransactionType
     */
    public $transactionType;

    /**
     * Request payment method
     *
     * @internal
     * @var IPaymentMethod
     */
    public $paymentMethod;

    /**
     * used w/TransIT gateway
     *
     * @var bool
     */
    public $multiCapture;

    /**
     * used w/TransIT gateway
     *
     * @var int
     */
    public $multiCaptureSequence;

    /**
     * used w/TransIT gateway
     *
     * @var int
     */
    public $multiCapturePaymentCount;

    /**
     * Request transaction modifier
     *
     * @internal
     * @var TransactionModifier
     */
    public $transactionModifier = TransactionModifier::NONE;

    /**
     * Request should allow duplicates
     *
     * @internal
     * @var bool
     */
    public $allowDuplicates;

    /**
     * Request supplementary data
     *
     * @var array
     */
    public $supplementaryData;

    /**
     * Instantiates a new builder
     *
     * @param TransactionType $type Request transaction type
     * @param IPaymentMethod $paymentMethod Request payment method
     *
     * @return
     */
    public function __construct($type, $paymentMethod = null)
    {
        parent::__construct();
        $this->transactionType = $type;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Set the request transaction type
     *
     * @internal
     * @param TransactionType $transactionType Request transaction type
     *
     * @return AuthorizationBuilder
     */
    public function withTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    /**
     * Set the request transaction modifier
     *
     * @internal
     * @param TransactionModifier $modifier Request transaction modifier
     *
     * @return AuthorizationBuilder
     */
    public function withModifier($modifier)
    {
        $this->transactionModifier = $modifier;
        return $this;
    }

    /**
     * Set the request to allow duplicates
     *
     * @param bool $allowDuplicates Request to allow duplicates
     *
     * @return AuthorizationBuilder
     */
    public function withAllowDuplicates($allowDuplicates)
    {
        $this->allowDuplicates = $allowDuplicates;
        return $this;
    }

    /**
     * Depending on the parameters received,
     * Add supplementary data or
     * Add multiple values to the supplementaryData array
     *
     * @param string|array<string, string>  $key
     * @param string $value
     *
     * @return $this
     */
    public function withSupplementaryData($key, $value = null)
    {
        if ($value === null && is_array($key)) {
            foreach ($key as $k => $v) {
                $this->withSupplementaryData($k, $v);
            }
        }

        if ($key && isset($value)) {
            $this->supplementaryData[$key] = $value;
        }

        return $this;
    }
}
