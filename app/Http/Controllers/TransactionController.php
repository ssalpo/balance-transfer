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
     * @return array
     */
    public function show($id)
    {
        $returnBuilder = true;

        $transaction = $this->transaction
            ->findById($id, ['sender', 'receiver'], $returnBuilder)
            ->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->first();

        return response()->json($transaction ?: []);
    }
}
