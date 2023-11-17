<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function findByUniqueId(string $uniqueId): ?Transaction
    {
        return Transaction::where('unique_id', $uniqueId)->first();
    }
}
