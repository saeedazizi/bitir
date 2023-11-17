<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Account;

class AccountFactory
{
    public function create(): Account
    {
        return new Account();
    }
}
