<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;

class AccountService
{
    public function __construct(private readonly AccountFactory $accountFactory)
    {}

    public function store(int $userId, float $balance): Account
    {
        $account = $this->accountFactory->create();
        $account->fill(['user_id' => $userId, 'balance' => $balance]);
        $account->save();

        return $account;
    }

    public function checkBalanceConstraint(Account $account, string $type, $amount): bool
    {
        if ($type === Transaction::TYPE_DEBIT && $amount > $account->balance) {
            return false;
        }

        return true;
    }
}
