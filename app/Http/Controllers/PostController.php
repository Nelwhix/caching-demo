<?php

namespace App\Http\Controllers;

use App\Filters\HasLinksFilter;
use App\Filters\HasMediaFilter;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    public function index()
    {
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters([
                AllowedFilter::custom('links', new HasLinksFilter()),
                AllowedFilter::custom('media', new HasMediaFilter()),
            ])
            ->allowedSorts([
                'created_at',
                'likes'
            ])
            ->with('media')
            ->limit(100)
            ->get();

        return response()->json([
            'message' => 'Get all posts.',
            'data' => PostResource::collection($posts),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $post = Post::create($validated);

        return response()->json([
            'message' => 'Post created.',
            'data' => PostResource::make($post),
        ]);
    }
}
