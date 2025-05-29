<?php

namespace App\Models\Repositories;

use App\Models\SpesialisasiUser;

class SpesialisasiUserRepository implements SpesialisasiUserRepositoryInterface
{
    public function findById(int $id)
    {
        return SpesialisasiUser::find($id);
    }

    public function create(array $data)
    {
        return SpesialisasiUser::create($data);
    }

    public function update(int $id, array $data)
    {
        $spesialisasiUser = SpesialisasiUser::find($id);
        if ($spesialisasiUser) {
            $spesialisasiUser->update($data);
            return $spesialisasiUser;
        }
        return null;
    }

    public function delete(int $id)
    {
        $spesialisasiUser = SpesialisasiUser::find($id);
        if ($spesialisasiUser) {
            $spesialisasiUser->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return SpesialisasiUser::all();
    }
}