<?php

namespace App\Repositories\Contracts;


use App\Transaction;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * Возвращает все транзакции по ID пользователя
     *
     * @param int $userId
     * @param array $with
     * @return Collection
     */
    public function findByUserId(int $userId, array $with = []): Collection;

    /**
     * Возвращает конкретную транзакцию по ID
     *
     * @param int $id
     * @param array $with
     * @return Transaction
     */
    public function findById(int $id, array $with = []): Transaction;
}
