<?php

namespace App\Http\Middleware;

use App\Repositories\TransactionRepository;
use Closure;
use Illuminate\Http\Request;
use Exception;

class IdempotencyMiddleware
{
    public function __construct(private readonly TransactionRepository $transactionRepository)
    {}

    public function handle(Request $request, Closure $next): mixed
    {
        $idempotencyValue = $request->header('idempotency-key');

        if (!$idempotencyValue) {
            throw new Exception('Idempotency key should be set!');
        }

        $transaction = $this->transactionRepository->findByUniqueId($idempotencyValue);

        if ($transaction) {
            return response()->json(['transaction' => $transaction]);
        }

        return $next($request);
    }
}
