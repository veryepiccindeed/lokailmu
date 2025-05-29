<?php

namespace App\Models\Repositories;

use App\Models\ForumPost;

class ForumPostRepository implements ForumPostRepositoryInterface
{
    public function findById(int $id)
    {
        return ForumPost::find($id);
    }

    public function create(array $data)
    {
        return ForumPost::create($data);
    }

    public function update(int $id, array $data)
    {
        $forumPost = ForumPost::find($id);
        if ($forumPost) {
            $forumPost->update($data);
            return $forumPost;
        }
        return null;
    }

    public function delete(int $id)
    {
        $forumPost = ForumPost::find($id);
        if ($forumPost) {
            $forumPost->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return ForumPost::all();
    }
}