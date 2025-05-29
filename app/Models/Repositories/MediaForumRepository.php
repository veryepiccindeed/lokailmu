<?php

namespace App\Models\Repositories;

use App\Models\MediaForum;

class MediaForumRepository implements MediaForumRepositoryInterface
{
    public function findById(int $id)
    {
        return MediaForum::find($id);
    }

    public function create(array $data)
    {
        return MediaForum::create($data);
    }

    public function update(int $id, array $data)
    {
        $mediaForum = MediaForum::find($id);
        if ($mediaForum) {
            $mediaForum->update($data);
            return $mediaForum;
        }
        return null;
    }

    public function delete(int $id)
    {
        $mediaForum = MediaForum::find($id);
        if ($mediaForum) {
            $mediaForum->delete();
            return true;
        }
        return false;
    }

    public function all()
    {
        return MediaForum::all();
    }
}