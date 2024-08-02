<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *     path="/api/blogs",
     *     tags={"Blog"},
     *     summary="Create a new blog post",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="My First Blog"),
     *             @OA\Property(property="content", type="string", example="This is the content of my first blog.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Blog created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="My First Blog"),
     *             @OA\Property(property="content", type="string", example="This is the content of my first blog."),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2021-01-01T00:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2021-01-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *     )
     * )
     */

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     $blog = Blog::create([
    //         'user_id' => $request->user()->id,
    //         'title' => $validated['title'],
    //         'content' => $validated['content'],
    //     ]);

    //     return response()->json($blog, 201);
    // }
    public function store(Request $request)
    {
        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return a 401 response with yung validation error
            return response()->json([
                'error' => 'Unauthorized',
                'message' => $e->errors()
            ], 401);
        }
    }
    
    /**
     * @OA\Get(
     *     path="/api/blogs",
     *     summary="List all blogs",
     *     description="Retrieve a list of all blog posts",
     *     operationId="getBlogs",
     *     tags={"Blogs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="The blog ID"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="The blog title"
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     description="The blog content"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="The creation date"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="The last update date"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */

    public function index()
    {
        // Retrieve lahat ng blog
        $blogs = Blog::all();
        // Return the blog posts as a JSON response
        return response()->json($blogs);
    }
    /**
     * @OA\Put(
     *     path="/api/blogs/{id}",
     *     summary="Update an existing blog",
     *     description="Update the blog identified by the provided ID. Only the owner of the blog can update it.",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the blog to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Blog Title"),
     *             @OA\Property(property="content", type="string", example="Updated content for the blog.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Blog updated successfully",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Blog not found"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function update(Request $request, $id)
    {
        // Find the blog by ID
        $blog = Blog::findOrFail($id);

        // Check if the authenticated user is the owner of the blog
        if ($request->user()->id !== $blog->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the request
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        // Update the blog
        $blog->update($validated);

        return response()->json($blog, 200);
    }


    /**
     * @OA\Delete(
     *     path="/api/blogs/{id}",
     *     summary="Delete a blog",
     *     description="Delete the blog identified by the provided ID. Only the owner of the blog can delete it.",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the blog to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Blog deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Blog not found"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function destroy(Request $request, $id)
    {
        // Find the blog by ID
        $blog = Blog::findOrFail($id);

        // Check if authenticated user is the owner of the blog
        if ($request->user()->id !== $blog->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        // Delete ang blog
        $blog->delete();

        return response()->json(null, 204);
    }
}
