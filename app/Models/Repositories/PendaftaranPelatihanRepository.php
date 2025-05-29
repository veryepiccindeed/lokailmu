<?php

namespace App\Models\Repositories;

use App\Models\PendaftaranPelatihan;

class PendaftaranPelatihanRepository implements PendaftaranPelatihanRepositoryInterface
{
    public function findById(string $id)
    {
        return PendaftaranPelatihan::find($id);
    }

    public function create(array $data)
    {
        return PendaftaranPelatihan::create($data);
    }

    public function update(string $id, array $data)
    {
        $pendaftaran = PendaftaranPelatihan::find($id);
        if ($pendaftaran) {
            $pendaftaran->update($data);
            return $pendaftaran;
        }
        return null;
    }

    public function delete(string $id)
    {
        $pendaftaran = PendaftaranPelatihan::find($id);
        if ($pendaftaran) {
            $pendaftaran->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return PendaftaranPelatihan::all();
    }
}