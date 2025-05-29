<?php

namespace App\Models\Repositories;

interface ForumPostRepositoryInterface
{
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function all();
}