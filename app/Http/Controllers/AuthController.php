<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;

/**
 * @OA\Info(title="Auth API", version="1.0")
 */

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="jessie conn sam"),
     *             @OA\Property(property="email", type="string", format="email", example="jessiesam.official@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Gv7#pR9&zLw!xQ2@fT4$kY1"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="Gv7#pR9&zLw!xQ2@fT4$kY1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="jessie conn sam"),
     *                 @OA\Property(property="email", type="string", format="email", example="jessiesam.official@gmail.com")
     *             ),
     *             @OA\Property(property="token", type="string", example="Bearer token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="field_name", type="array", @OA\Items(type="string", example="The field_name field is required."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="field_name", type="array", @OA\Items(type="string", example="The field_name field is required."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred during registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred during registration"),
     *             @OA\Property(property="error", type="string", example="Exception message")
     *         )
     *     )
     * )
     */

    //old version
    // public function register(Request $request)
    // {
    //     $data = $request->validate([
    //         'name' => ['required', 'string'],
    //         'email' => ['required', 'email', 'unique:users'],
    //         'password' => [
    //             'required',
    //             //password policy
    //              Password::min(8)
    //                 ->letters()
    //                 ->mixedCase()
    //                 ->numbers()
    //                 ->symbols()
    //                 ->uncompromised(),
    //         ],
    //     ]);

    //     // Hash the password before saving
    //     $data['password'] = Hash::make($data['password']);

    //     $user = User::create($data);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return [
    //         'message' => 'User registered successfully',
    //         'user' => $user,
    //         'token' => $token
    //     ];
    // }

    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    //password policy
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(),
                    'confirmed',  // Requires password_confirmation field
                ],
            ], [
                'name.required' => 'Name is required.',
                'email.required' => 'Email is required.',
                'email.unique' => 'This email is already registered.',
                'password.required' => 'Password is required.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password' => 'Password must be at least 8 characters long and include uppercase and lowercase letters, numbers, and symbols.',
            ]);

            // Hash the password before saving
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $token
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Log in a user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="jessiesam.official@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Gv7#pR9&zLw!xQ2@fT4$kY1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="user", type="object", 
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="johndoe@example.com")
     *             ),
     *             @OA\Property(property="token", type="string", example="Bearer token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid Credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid Credentials")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too many login attempts",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Too many login attempts. Please try again in 60 seconds.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(property="errors", type="object", 
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="The email field is required.")),
     *                 @OA\Property(property="password", type="array", @OA\Items(type="string", example="The password field is required."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred during login",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred during login"),
     *             @OA\Property(property="error", type="string", example="Exception message")
     *         )
     *     )
     * )
     */
    
    //old version 
    // public function login(Request $request)
    // {
    //     $data = $request->validate([
    //         'email' => ['required', 'email', 'exists:users,email'],
    //         'password' => ['required', 'min:8'],
    //     ]);

    //     $user = User::where('email', $data['email'])->first();

    //     if (!$user || !Hash::check($data['password'], $user->password)) {
    //         return response([
    //             'message' => 'Invalid Credentials'
    //         ], 401);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return [
    //         'message' => 'Login successfully',
    //         'user' => $user,
    //         'token' => $token
    //     ];
    // }

    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required', 'min:8'],
            ]);

            $key = 'login_attempts_' . $request->ip();
            $maxAttempts = 2; //change for testing only
            $decayMinutes = 1;

            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                $seconds = RateLimiter::availableIn($key);
                return response([
                    'message' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.'
                ], 429);
            }

            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                RateLimiter::hit($key); // Increment failed attempt
                return response([
                    'message' => 'Invalid Credentials'
                ], 401);
            }

            RateLimiter::clear($key);

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An errorr during Login',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="Log out the current user",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }


    /**
     * @OA\Patch(
     *     path="/user/update",
     *     summary="Update the authenticated user's information",
     *     description="Allows the authenticated user to update their email and/or password.",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     ),
     *     security={{ "bearerAuth": {} }}
     * )
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = $request->user(); // Get the authenticated user

        // Validate the incoming request
        $data = $request->validate([
            'email' => ['nullable', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:8'],
        ]);

        // Update the user's email if provided
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        // Update the user's password if provided
        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }
}
