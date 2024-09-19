<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $module = 'User';
    private $userRepository; 

    function __construct() {
        $this->userRepository = new UserRepository();
    }

    function me ()
    {
        $data = auth()->user();

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data fetched successfully."
        ]);
    }

    function index() {
        $limit = request()->query('limit', 10);

        $data = Cache::tags([app_key(), 'users'])->rememberForever(cache_key('users', request()->all()), function() use($limit) { 
            $data = $this->userRepository->paginate($limit);
            return $data;
        });

        UserResource::collection($data);

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data fetched successfully."
        ]);
    }

    function find($id) {
        $data = Cache::tags([app_key(), 'users'])->rememberForever(cache_key('users', ['id' => $id]), function() use($id) { 
            return $this->userRepository->find($id);
        });

        if(!$data) {
            return response()->json([
                'status'  => 'error',
                'data'    => null,
                'message' => "{$this->module} data not found."
            ], 404);
        }

        $data = new UserResource($data);
            
        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data fetched successfully."
        ]);
    }
}
