<?php

namespace App\Repositories\Contracts;


use App\Transaction;

interface TransactionInterface
{
    /**
     * Сохраняет информацию о транзакции
     *
     * @param int $sender
     * @param int $receiver
     * @param float $amount
     * @return Transaction
     */
    public function save(int $sender, int $receiver, float $amount): Transaction;
}
