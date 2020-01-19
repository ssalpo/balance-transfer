<?php

namespace App\Http\Controllers;

use App\Exceptions\IncorrectBalanceException;
use App\Http\Requests\Api\TransferRequest;
use App\Repositories\Contracts\BalanceInterface;
use App\Repositories\Contracts\UserInterface;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class BalanceController extends Controller
{
    /**
     * @var BalanceInterface
     */
    private $balance;
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * BalanceController constructor.
     * @param BalanceInterface $balance
     * @param UserInterface $user
     */
    public function __construct(BalanceInterface $balance, UserInterface $user)
    {
        $this->balance = $balance;
        $this->user = $user;
    }

    public function transfer(TransferRequest $request)
    {
        try {

            $receiver = $request->get('receiver_id');

            if ($request->has('email')) {
                $receiver = ($this->user->find($request->post('email'), 'email'))->id;
            }

            $isTransferred = $this->balance->transfer(
                (int)auth()->id(), (int)$receiver, (double)$request->post('amount')
            );

            return response()->json(['status' => $isTransferred]);
        } catch (\Exception $e) {

            if (
                $e instanceof IncorrectBalanceException ||
                $e instanceof ValidationException ||
                $e instanceof ModelNotFoundException
            ) {
                $message = $e->getMessage();
            } else {
                Log::critical('Something went wrong while process transfer. Message: ' . $e->getMessage(), $e->getTrace());
                $message = 'Something went wrong while process transfer. Please contact with administrators!';
            }

            return response()->json(['status' => 'error', 'errors' => $message]);
        }


    }


    /**
     * Баланс авторизованного пользователя
     *
     * @return array
     */
    public function show()
    {
        $balance = $this->balance->findByUser(auth()->id());

        return [
            'balance' => $balance->amount,
        ];
    }

}
