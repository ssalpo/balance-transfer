<?php

namespace App\Repositories\Contracts;


use App\Balance;

interface BalanceInterface
{
    /**
     * Проводит трнзакицю между пользователями
     *
     * @param int $sender ID отправителя
     * @param int $receiver ID получателя
     * @param float $amount Кол-во переводимых денег
     * @return bool
     * @throws \Exception
     */
    public function transfer(int $sender, int $receiver, float $amount): bool;

    /**
     * Проверяет остаток баланса отправител
     *
     * @param int $sender
     * @param float $amount
     * @return bool
     */
    public function checkSenderBalance(int $sender, float $amount): bool;

    /**
     * Возвращает объек баланса по ID пользователя
     *
     * @param int $userId
     * @return Balance
     */
    public function findByUser(int $userId): Balance;

    /**
     * Прибавляет сумму баланса со счета пользователя
     * @param int $userId
     * @param float $amount
     * @return int
     */
    public function incrementAmount(int $userId, float $amount): int;

    /**
     * Уменьшает сумму баланса со счета пользователя
     * @param int $userId
     * @param float $amount
     * @return int|null
     */
    public function decrementAmount(int $userId, float $amount): ?int;
}
