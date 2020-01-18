<?php

namespace App\Repositories;


use App\Repositories\Contracts\UserInterface;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function find($value, string $column = 'id'): User
    {
        $user = User::where($column, $value)->first();

        if (!$user) {
            throw new ModelNotFoundException('User not found!');
        }

        return $user;
    }
}
