<?php

namespace App\Models\Repositories;

use App\Models\Pelatihan;

class PelatihanRepository implements PelatihanRepositoryInterface
{
    public function findById(string $id)
    {
        return Pelatihan::find($id);
    }

    public function create(array $data)
    {
        return Pelatihan::create($data);
    }

    public function update(string $id, array $data)
    {
        $pelatihan = Pelatihan::find($id);
        if ($pelatihan) {
            $pelatihan->update($data);
            return $pelatihan;
        }
        return null;
    }

    public function delete(string $id)
    {
        $pelatihan = Pelatihan::find($id);
        if ($pelatihan) {
            $pelatihan->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return Pelatihan::all();
    }
}