<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Post();
    }

    function findWithComments($id) {
        return $this->model->with(['user', 'comments.user'])->find($id);
    }
}
