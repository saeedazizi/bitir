<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionHandler;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(private readonly TransactionHandler $transactionHandler)
    {
    }

    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = $this->transactionHandler->store(
            intval($request->get('account_id')),
            $request->get('type'),
            floatval($request->get('amount')),
            $request->header('idempotency-key'),
        );

        return response()->json(['transaction' => $transaction]);
    }
}
