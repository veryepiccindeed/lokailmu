<?php

namespace App\Models\Repositories;

use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function findById(string $id)
    {
        return Tag::find($id);
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function update(string $id, array $data)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->update($data);
            return $tag;
        }
        return null;
    }

    public function delete(string $id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return Tag::all();
    }
}