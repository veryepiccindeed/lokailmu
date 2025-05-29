<?php

namespace App\Models\Repositories;

use App\Models\ProfilGuru;

class ProfilGuruRepository implements ProfilGuruRepositoryInterface
{
    public function findById(string $id)
    {
        return ProfilGuru::find($id);
    }

    public function create(array $data)
    {
        return ProfilGuru::create($data);
    }

    public function update(string $id, array $data)
    {
        $profilGuru = ProfilGuru::find($id);
        if ($profilGuru) {
            $profilGuru->update($data);
            return $profilGuru;
        }
        return null;
    }

    public function delete(string $id)
    {
        $profilGuru = ProfilGuru::find($id);
        if ($profilGuru) {
            $profilGuru->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return ProfilGuru::all();
    }
}