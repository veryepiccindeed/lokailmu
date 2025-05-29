<?php

namespace App\Models\Repositories;

use App\Models\DaftarBuku;

class DaftarBukuRepository implements DaftarBukuRepositoryInterface
{
    public function findById(string $id)
    {
        return DaftarBuku::find($id);
    }

    public function create(array $data)
    {
        return DaftarBuku::create($data);
    }

    public function update(string $id, array $data)
    {
        $daftarBuku = DaftarBuku::find($id);
        if ($daftarBuku) {
            $daftarBuku->update($data);
            return $daftarBuku;
        }
        return null;
    }

    public function delete(string $id)
    {
        $daftarBuku = DaftarBuku::find($id);
        if ($daftarBuku) {
            $daftarBuku->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return DaftarBuku::all();
    }
}