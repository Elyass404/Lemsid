<?php

namespace App\Repositories\Interfaces;

interface TagRepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function delete(int $id);
}
