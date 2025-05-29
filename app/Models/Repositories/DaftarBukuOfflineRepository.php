<?php

namespace App\Models\Repositories;

use App\Models\DaftarBukuOffline;

class DaftarBukuOfflineRepository implements DaftarBukuOfflineRepositoryInterface
{
    public function findById(string $id)
    {
        return DaftarBukuOffline::find($id);
    }

    public function create(array $data)
    {
        return DaftarBukuOffline::create($data);
    }

    public function update(string $id, array $data)
    {
        $daftarBukuOffline = DaftarBukuOffline::find($id);
        if ($daftarBukuOffline) {
            $daftarBukuOffline->update($data);
            return $daftarBukuOffline;
        }
        return null;
    }

    public function delete(string $id)
    {
        $daftarBukuOffline = DaftarBukuOffline::find($id);
        if ($daftarBukuOffline) {
            $daftarBukuOffline->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return DaftarBukuOffline::all();
    }
}