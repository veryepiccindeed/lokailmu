<?php

namespace App\Models\Repositories;

use App\Models\Sekolah;

class SekolahRepository implements SekolahRepositoryInterface
{
    public function findById(int $id)
    {
        return Sekolah::find($id);
    }

    public function create(array $data)
    {
        return Sekolah::create($data);
    }

    public function update(int $id, array $data)
    {
        $sekolah = Sekolah::find($id);
        if ($sekolah) {
            $sekolah->update($data);
            return $sekolah;
        }
        return null;
    }

    public function delete(int $id)
    {
        $sekolah = Sekolah::find($id);
        if ($sekolah) {
            $sekolah->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return Sekolah::all();
    }
}