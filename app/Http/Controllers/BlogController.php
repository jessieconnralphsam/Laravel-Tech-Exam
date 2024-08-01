<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;

    // Remove the constructor middleware call
    // Use route middleware for authentication

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $blog = Blog::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return response()->json($blog, 201);
    }

    // public function index()
    // {
    //     $blogs = Blog::with('user')->get();
    //     return response()->json($blogs);
    // }

    // public function show(Blog $blog)
    // {
    //     return response()->json($blog->load('user'));
    // }

    // public function update(Request $request, Blog $blog)
    // {
    //     $this->authorize('update', $blog);

    //     $validated = $request->validate([
    //         'title' => 'sometimes|string|max:255',
    //         'content' => 'sometimes|string',
    //     ]);

    //     $blog->update($validated);

    //     return response()->json($blog);
    // }

    // public function destroy(Blog $blog)
    // {
    //     $this->authorize('delete', $blog);

    //     $blog->delete();

    //     return response()->json(null, 204);
    // }
}
