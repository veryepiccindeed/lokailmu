<?php

namespace App\Models\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findById(string $id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(string $id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return User::all();
    }
}