<?php

namespace App\Models\Repositories;

use App\Models\Pembayaran;

class PembayaranRepository implements PembayaranRepositoryInterface
{
    public function findById(string $id)
    {
        return Pembayaran::find($id);
    }

    public function create(array $data)
    {
        return Pembayaran::create($data);
    }

    public function update(string $id, array $data)
    {
        $pembayaran = Pembayaran::find($id);
        if ($pembayaran) {
            $pembayaran->update($data);
            return $pembayaran;
        }
        return null;
    }

    public function delete(string $id)
    {
        $pembayaran = Pembayaran::find($id);
        if ($pembayaran) {
            $pembayaran->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return Pembayaran::all();
    }
}