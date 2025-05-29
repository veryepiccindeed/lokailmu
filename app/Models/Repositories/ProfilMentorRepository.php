<?php

namespace App\Models\Repositories;

use App\Models\ProfilMentor;

class ProfilMentorRepository implements ProfilMentorRepositoryInterface
{
    public function findById(string $id)
    {
        return ProfilMentor::find($id);
    }

    public function create(array $data)
    {
        return ProfilMentor::create($data);
    }

    public function update(string $id, array $data)
    {
        $profilMentor = ProfilMentor::find($id);
        if ($profilMentor) {
            $profilMentor->update($data);
            return $profilMentor;
        }
        return null;
    }

    public function delete(string $id)
    {
        $profilMentor = ProfilMentor::find($id);
        if ($profilMentor) {
            $profilMentor->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return ProfilMentor::all();
    }
}