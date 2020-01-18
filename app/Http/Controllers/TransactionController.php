<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TransactionInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @var TransactionInterface
     */
    private $transaction;

    /**
     * TransactionController constructor.
     * @param TransactionInterface $transaction
     */
    public function __construct(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Возвращает все транзакции авторизованного пользователя
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return $this->transaction->findByUserId(
            auth()->id(), ['sender', 'receiver']
        );
    }

    /**
     * Возвращает конкретную транзакцию по ID
     *
     * @param $id
     * @return \App\Transaction
     */
    public function show($id)
    {
        return $this->transaction->findById($id, ['sender', 'receiver']);
    }
}
