<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_id' => 'required|numeric|exists:accounts,id',
            'type' => 'required|in:debit,credit',
            'amount' => 'required|numeric',
        ];
    }
}
