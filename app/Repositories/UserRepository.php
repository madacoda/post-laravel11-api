<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserRepository extends Repository
{
    public function __construct()
    {
        $this->model = new User();
    }
}
