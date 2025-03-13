<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    public function getAll()
    {
        return Tag::all();
    }

    public function getById($id)
    {
        return Tag::findOrFail($id);
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function update($id, array $data)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($data);
        return $tag;
    }

    public function delete($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
    }
}
