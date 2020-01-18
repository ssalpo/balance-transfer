<?php

namespace App\Http\Controllers;

use App\Exceptions\IncorrectBalanceException;
use App\Http\Requests\Api\TransferRequest;
use App\Repositories\Contracts\BalanceInterface;
use Dotenv\Exception\ValidationException;
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
                (int)auth()->id(), (int)$request->get('receiver_id'), (double)$request->get('amount')
            );

            return response()->json(['status' => $isTransferred]);
        } catch (\Exception $e) {

            if ($e instanceof IncorrectBalanceException || $e instanceof ValidationException) {
                $message = $e->getMessage();
            } else {
                Log::critical('Something went wrong while process transfer. Message: ' . $e->getMessage(), $e->getTrace());
                $message = 'Something went wrong while process transfer. Please contact with administrators!';
            }

            return response()->json(['status' => 'error', 'errors' => $message]);
        }


    }
}
