<?php

namespace App\Services;

use Carbon\Carbon;

class StatisticsService extends BaseService
{
    public function getStatistics()
    {
        $transactions = $this->consumeTransactions();
        $now = Carbon::now();

        $validTransactions = array_filter($transactions, function ($transaction) use ($now) {
            $secondsDiff = Carbon::parse($transaction['timestamp'])->diffInSeconds($now);

            return $secondsDiff <= $this->ttl;
        });

        $totalAmount = array_sum(array_column($validTransactions, 'amount'));
        $totalCount = count($validTransactions);
        $maxAmount = $totalCount > 0 ? max(array_column($validTransactions, 'amount')) : 0;
        $minAmount = $totalCount > 0 ? min(array_column($validTransactions, 'amount')) : 0;
        $average = $totalCount > 0 ? round($totalAmount / $totalCount, 2) : 0.00;

        return [
            'sum' => round($totalAmount, 2),
            'avg' => $average,
            'max' => round($maxAmount, 2),
            'min' => round($minAmount, 2),
            'count' => $totalCount,
        ];
    }
}
