<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PostController extends Controller
{
    private $module = 'Post';
    private $postRepository;

    function __construct() {
        $this->postRepository = new PostRepository();
    }

    function index() {
        $limit = request()->query('limit', 10);

        $data = Cache::tags([app_key(), 'posts'])->rememberForever(cache_key('posts', request()->all()), function() use($limit) { 
            $data = $this->postRepository->paginate($limit);
            return $data;
        });
        PostResource::collection($data);

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data fetched successfully."
        ]);
    }

    function store(Request $request) {
        $request->validate([
            'title'   => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        $input            = $request->all();
        $input['user_id'] = auth()->user()->id;
        $input['slug']    = Str::slug($input['title']);
        $input['slug']    = uniqify_slug($input['slug']);

        $data             = $this->postRepository->store($input);

        Cache::tags(['posts'])->flush();

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data created successfully."
        ], 201);
    }

    function find($id) {
        $data = Cache::tags([app_key(), 'posts'])->rememberForever(cache_key('posts', ['id' => $id]), function() use($id) { 
            return new PostDetailResource($this->postRepository->findWithComments($id));
        });

        if(!$data || !$data->resource) {
            return response()->json([
                'status'  => 'error',
                'data'    => null,
                'message' => "{$this->module} data not found."
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data fetched successfully."
        ]);
    }

    function update(Request $request, $id) {
        $request->validate([
            'title'   => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        $data = $this->postRepository->find($id);

        if (!$data) {
            return response()->json([
                'status'  => 'error',
                'data'    => null,
                'message' => "{$this->module} data not found."
            ], 404);
        }

        if($data->user_id != auth()->user()->id) {
            return response()->json([
                'status'  => 'error',
                'message' => "You are not authorized to update this {$this->module} data."
            ], 401);
        }

        $input        = $request->all();
        $data         = $this->postRepository->update($input, $id);
        $data         = new PostResource($data);

        Cache::tags(['posts'])->flush();

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data updated successfully."
        ]);
    }

    function destroy($id) {
        $data = $this->postRepository->find($id);

        if (!$data) {
            return response()->json([
                'status'  => 'error',
                'message' => "{$this->module} data not found."
            ], 404);
        }

        if($data->user_id !== auth()->user()->id) {
            return response()->json([
                'status'  => 'error',
                'message' => "You are not authorized to delete this {$this->module} data."
            ], 401);
        }

        $this->postRepository->destroy($id);

        Cache::tags(['posts'])->flush();

        return response()->json([
            'status'  => 'success',
            'message' => "{$this->module} data deleted successfully."
        ]);
    }
}
