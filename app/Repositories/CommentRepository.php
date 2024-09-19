<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Comment();
    }
}
