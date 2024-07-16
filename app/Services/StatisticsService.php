<?php

namespace App\Services;

class StatisticsService extends BaseService
{
    public function getStatistics()
    {
        $transactions = $this->consumeTransactions();

        $totalAmount = array_sum(array_column($transactions, 'amount'));
        $totalCount = count($transactions);
        $maxAmount = $totalCount > 0 ? max(array_column($transactions, 'amount')) : 0;
        $minAmount = $totalCount > 0 ? min(array_column($transactions, 'amount')) : 0;
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
