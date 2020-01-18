<?php

namespace App\Repositories;


use App\Repositories\Contracts\TransactionInterface;
use App\Transaction;

class TransactionRepository implements TransactionInterface
{
    /**
     * @var Transaction
     */
    private $model;

    /**
     * TransactionRepository constructor.
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function save(int $sender, int $receiver, float $amount): Transaction
    {
        return Transaction::create([
            'sender_id' => $sender,
            'receiver_id' => $receiver,
            'amount' => $amount
        ]);
    }
}
