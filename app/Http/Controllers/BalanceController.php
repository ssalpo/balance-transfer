<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\TransferRequest;
use App\Repositories\Contracts\BalanceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BalanceController extends Controller
{
    /**
     * @var BalanceInterface
     */
    private $balance;

    /**
     * BalanceController constructor.
     * @param BalanceInterface $balance
     */
    public function __construct(BalanceInterface $balance)
    {
        $this->balance = $balance;
    }

    public function transfer(TransferRequest $request)
    {
        try {

            $isTransferred = $this->balance->transfer(
                1, $request->get('receiver_id'), $request->get('amount')
            );

            return response()->json(['status' => $isTransferred]);
        } catch (\Exception $e) {

            Log::critical('Something went wrong while process transfer. Message: ' . $e->getMessage(), $e->getTrace());

            return response()->json(['status' => 'error', 'errors' => 'Something went wrong while process transfer. Please contact with administrators!']);
        }


    }
}
