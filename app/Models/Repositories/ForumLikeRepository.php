<?php

namespace App\Models\Repositories;

use App\Models\ForumLike;

class ForumLikeRepository implements ForumLikeRepositoryInterface
{
    public function findById(int $id)
    {
        return ForumLike::find($id);
    }

    public function create(array $data)
    {
        return ForumLike::create($data);
    }

    public function update(int $id, array $data)
    {
        $forumLike = ForumLike::find($id);
        if ($forumLike) {
            $forumLike->update($data);
            return $forumLike;
        }
        return null;
    }

    public function delete(int $id)
    {
        $forumLike = ForumLike::find($id);
        if ($forumLike) {
            $forumLike->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return ForumLike::all();
    }
}