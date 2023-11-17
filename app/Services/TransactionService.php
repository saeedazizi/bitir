<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function __construct(private readonly TransactionFactory $transactionFactory)
    {
    }

    public function store(int $accountId, string $type, float $amount, string $uniqueId): Transaction
    {
        $transaction = $this->transactionFactory->create();
        $transaction->fill(
            [
                'account_id' => $accountId,
                'type' => $type,
                'amount' => $amount,
                'unique_id' => $uniqueId
            ]
        );
        $transaction->save();

        return $transaction;
    }
}
