<?php

namespace App\Repositories\Contracts;


use App\User;

interface UserInterface
{
    /**
     * Проверяет существование пользователя по ID
     *
     * @param int $id User id
     * @return bool
     */
    public function isExist(int $id): bool;

    /**
     * Поиск пользователя по ID
     *
     * @param mixed $value
     * @param string $column
     * @return User
     */
    public function find($value, string $column = 'id'): User;
}
