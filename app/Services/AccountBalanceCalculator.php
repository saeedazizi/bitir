<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Transaction;

class AccountBalanceCalculator
{
    public function calculate(float $balance, string $type, float $amount): float
    {
        if ($type === Transaction::TYPE_DEBIT) {
            return $balance - $amount;
        }

        return $balance + $amount;
    }
}
