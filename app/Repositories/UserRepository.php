<?php

namespace App\Repositories;


use App\Repositories\Contracts\UserInterface;
use App\User;

class UserRepository implements UserInterface
{
    /**
     * {@inheritDoc}
     */
    public function isExist(int $id): bool
    {
        return User::where('id', $id)->exists();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): User
    {
        return User::findOrFail($id);
    }
}
