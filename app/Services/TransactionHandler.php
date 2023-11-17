<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\BalanceConstraintException;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use Illuminate\Database\DatabaseManager;
use Throwable;

class TransactionHandler
{
    public function __construct(
        private readonly AccountRepository $accountRepository,
        private readonly AccountService $accountService,
        private readonly TransactionService $transactionService,
        private readonly DatabaseManager $databaseManager,
        private readonly AccountBalanceCalculator $accountBalanceCalculator
    ) {
    }

    public function store(int $accountId, string $type, float $amount, string $uniqueId): Transaction
    {
        $this->databaseManager->beginTransaction();

        try {
            $account = $this->accountRepository->findAndLock($accountId);
            if (!$this->accountService->checkBalanceConstraint($account, $type, $amount)) {
                throw new BalanceConstraintException('Amount is bigger than balance!');
            }

            $finalBalance = $this->accountBalanceCalculator->calculate(floatval($account->balance), $type, $amount);

            $this->accountRepository->update($account, ['balance' => $finalBalance]);
            $transaction = $this->transactionService->store($accountId, $type, $amount, $uniqueId);
            $this->databaseManager->commit();

            return $transaction;
        } catch (Throwable $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }
    }
}
