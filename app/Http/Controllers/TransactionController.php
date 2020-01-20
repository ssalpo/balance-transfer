<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TransactionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $returnBuilder = true;

        $transaction = $this->transaction
            ->findById($id, ['sender', 'receiver'], $returnBuilder)
            ->whereRaw('(sender_id=? OR receiver_id=?)', [auth()->id(),auth()->id()])
            ->first();

        return response()->json($transaction ?: []);
    }
}
