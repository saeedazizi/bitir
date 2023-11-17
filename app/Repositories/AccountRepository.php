<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository
{
    public function findAccountTransactions(int $id): Collection
    {
        return Account::find($id)
            ->transactions()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
        ;
    }

    public function findAndLock(int $id): ?Account
    {
        return Account::sharedLock()->find($id);
    }

    public function update(Account $account, array $data): Account
    {
        $account->update($data);

        return $account;
    }

    public function find(int $id): Account
    {
        return Account::findOrFail($id);
    }
}
