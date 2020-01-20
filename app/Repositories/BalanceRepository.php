<?php

namespace App\Repositories;


use App\Balance;
use App\Exceptions\IncorrectBalanceException;
use App\Repositories\Contracts\BalanceInterface;
use App\Repositories\Contracts\TransactionInterface;
use App\Repositories\Contracts\UserInterface;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BalanceRepository implements BalanceInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var TransactionInterface
     */
    private $transactionRepo;

    /**
     * BalanceRepository constructor.
     * @param UserInterface $userRepository
     * @param TransactionInterface $transactionRepo
     */
    public function __construct(UserInterface $userRepository, TransactionInterface $transactionRepo)
    {
        $this->userRepository = $userRepository;
        $this->transactionRepo = $transactionRepo;
    }

    /**
     * {@inheritDoc}
     */
    public function transfer(int $sender, int $receiver, float $amount): bool
    {
        if ($this->validateTransferInput($sender, $receiver, $amount)) {
            throw  new ValidationException('Wrong input data!');
        }

        if ($this->checkSenderBalance($sender, $amount)) {
            throw  new IncorrectBalanceException('Not enough funds in the account!');
        }

        try {
            DB::beginTransaction();

            if (!$this->decrementAmount($sender, $amount) || !$this->incrementAmount($receiver, $amount)) {
                throw new \Exception('Error while incrementing or decrementing user amount!');
            }

            $this->transactionRepo->save($sender, $receiver, $amount);

            // Здесь дальше можно уже отправлять сообщения пользователю и т.д

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::critical('Error while beginning real transfer process! ' . $e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function checkSenderBalance(int $sender, float $amount): bool
    {
        $balance = $this->findByUser($sender);

        if (!$balance) {
            throw new ModelNotFoundException('Wallet not attached to this user! User ID:' . $sender);
        }

        return $balance->amount <= 0 || $balance->amount < $amount;
    }

    /**
     * Валидирует входные данные при переводе условных единиц
     *
     * @param int $sender
     * @param int $receiver
     * @param float $amount
     * @return bool
     */
    protected function validateTransferInput(int $sender, int $receiver, float $amount): bool
    {
        $isSenderExist = $this->userRepository->isExist($sender);
        $isReceiverExist = $this->userRepository->isExist($receiver);

        return !$isSenderExist || !$isReceiverExist || $sender == $receiver || $amount <= 0;
    }


    /**
     * {@inheritDoc}
     */
    public function findByUser(int $userId, bool $returnBuilder = false): ?Balance
    {
        $balance = Balance::where('user_id', $userId);

        if ($returnBuilder) {
            return $balance;
        }

        return $balance->first();
    }

    /**
     * {@inheritDoc}
     */
    public function incrementAmount(int $userId, float $amount): int
    {
        $balance = $this->findByUser($userId);

        return $balance->increment('amount', $amount);
    }

    /**
     * {@inheritDoc}
     */
    public function decrementAmount(int $userId, float $amount): ?int
    {
        $balance = $this->findByUser($userId);

        if (($balance->amount - $amount) < 0) {
            return null;
        }

        return $balance->decrement('amount', $amount);
    }
}
