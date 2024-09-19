<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    private $module = 'Comment';
    private $commentRepository;

    function __construct() {
        $this->commentRepository = new CommentRepository();
    }

    function store(Request $request) {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|min:3',
        ]);

        $input            = $request->all();
        $input['user_id'] = auth()->user()->id;

        $data = $this->commentRepository->store($input);

        Cache::tags(['posts', 'comments'])->flush();

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data created successfully."
        ], 201);
    }

    function find($id) {
        $data = Cache::tags([app_key(), 'comments'])->rememberForever(cache_key('comments', ['id' => $id]), function() use($id) { 
            return new CommentResource($this->commentRepository->find($id));
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
}
