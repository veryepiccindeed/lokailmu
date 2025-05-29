<?php

namespace App\Models\Repositories;

use App\Models\ThreadForum;

class ThreadForumRepository implements ThreadForumRepositoryInterface
{
    public function findById(string $id)
    {
        return ThreadForum::find($id);
    }

    public function create(array $data)
    {
        return ThreadForum::create($data);
    }

    public function update(string $id, array $data)
    {
        $thread = ThreadForum::find($id);
        if ($thread) {
            $thread->update($data);
            return $thread;
        }
        return null;
    }

    public function delete(string $id)
    {
        $thread = ThreadForum::find($id);
        if ($thread) {
            $thread->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return ThreadForum::all();
    }
}