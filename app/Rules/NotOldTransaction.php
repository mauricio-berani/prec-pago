<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotOldTransaction implements ValidationRule
{
    protected $ttl;

    public function __construct()
    {
        $this->ttl = config('transactions.ttl');
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $timestamp = Carbon::parse($value);
        $now = Carbon::now();

        if ($timestamp->diffInSeconds($now) > $this->ttl) {
            $fail('Transaction timestamp exceeds validity period.');
        }
    }
}
