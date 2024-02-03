<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validate the user credentials
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Attempt to log in the user using JWT
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Retrieve the authenticated user
        $user = auth()->user();

        // Include the user's role in the response
        return $this->respondWithToken($token, $user->role);
    }

    // Example login method using 'api' guard
    public function loginWithApiGuard(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validate the user credentials
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Attempt to log in the user using the 'api' guard
        if (Auth::guard('api')->attempt($credentials)) {
            // Authentication passed
            $token = JWTAuth::fromUser(Auth::guard('api')->user());

            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,teacher,student'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = \App\Models\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        // Redirect the user based on their role
        return $this->respondWithTokenAndRedirect($token, $user->role);
    }

    protected function respondWithToken($token, $role)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'role' => $role, // Include the user's role in the response
        ]);
    }

    protected function respondWithTokenAndRedirect($token, $role)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'role' => $role, // Include the user's role in the response
        ], $this->getRedirectStatusCode($role));
    }

    protected function getRedirectStatusCode($role)
    {
        // Define your redirection logic based on the user's role
        switch ($role) {
            case 'admin':
                return 201; // HTTP status code for successful creation
            case 'teacher':
                return 202; // HTTP status code for accepted
            case 'student':
                return 203; // HTTP status code for non-authoritative information
            default:
                return 200; // Default HTTP status code
        }
    }

    public function logout()
    {
        // Log the user out and invalidate the token
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Logout successful']);
    }
}
