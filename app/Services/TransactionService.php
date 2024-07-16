<?php

namespace App\Services;

use App\Enums\TransactionStatus;

class TransactionService extends BaseService
{
    public function create($amount, $timestamp)
    {
        try {
            $transaction = ['amount' => $amount, 'timestamp' => $timestamp];

            $this->publishTransaction($transaction);

            return TransactionStatus::SUCCESS->value;
        } catch (\Exception $error) {
            return TransactionStatus::ERROR->value;
        }
    }

    public function delete()
    {
        try {
            $this->purgeQueue($this->queueName);
        } catch (\Exception $error) {
            return TransactionStatus::ERROR->value;
        }
    }
}
