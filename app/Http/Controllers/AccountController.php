<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Repositories\AccountRepository;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService,
        private readonly AccountRepository $accountRepository
    ) {
    }

    public function store(StoreAccountRequest $request): JsonResponse
    {
        $account = $this->accountService->store($request->get('user_id'), $request->get('balance'));

        return response()->json(['account' => $account]);
    }

    public function getBalance(int $id): JsonResponse
    {
        $account = $this->accountRepository->find($id);

        return response()->json(['balance' => $account->balance]);
    }

    public function getTransactions(int $id): JsonResponse
    {
        $transactions = $this->accountRepository->findAccountTransactions($id);

        return response()->json(['transactions' => $transactions]);
    }
}
