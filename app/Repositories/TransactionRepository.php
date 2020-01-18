<?php

namespace App\Repositories;


use App\Repositories\Contracts\TransactionInterface;
use App\Transaction;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @inheritDoc
     */
    public function findByUserId(int $userId, array $with = []): Collection
    {
        $transaction = Transaction::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId);

        if ($with) {
            $transaction->with($with);
        }

        return $transaction->get();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id, array $with = []): Transaction
    {
        $transaction = Transaction::where('id', $id);

        if ($with) {
            $transaction->with($with);
        }

        return $transaction->first();
    }
}
