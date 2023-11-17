<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Transaction;

class TransactionFactory
{
    public function create(): Transaction
    {
        return new Transaction();
    }
}
