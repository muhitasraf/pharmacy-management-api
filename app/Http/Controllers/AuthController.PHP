<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct() {
        $this->middleware('auth', ['except' => ['login', 'register', ]]);
    }

    /**
     * Attempt to register a new user to the API.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {

        $this->validate($request, [
            'full_name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required',
            'password' => 'required|min:6',
            'cpassword' => 'required|min:6|same:password',
        ]);

        try {
            $user = new User;
            $user->name = $request->input('fullname');
            $user->email = $request->input('email');
            $user->user_name = $request->input('user_name');
            $user->contact_number = $request->input('contact_number');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    /**
     * Attempt to authenticate the user and retrieve a JWT.
     * Note: The API is stateless. This method _only_ returns a JWT. There is not an
     * indicator that a user is logged in otherwise (no sessions).
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        try{
            // Are the proper fields present?
            $this->validate($request, [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
        }catch(ValidationException $exception){
            return response()->json([
                'success' => false,
                 'message' => $exception->getMessage(),
            ],422);
        }


        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            // Login has failed
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credential!'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token). Requires a login to use as the
     * JWT in the Authorization header is what is invalidated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh the current token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken( JWTAuth::refresh() );
    }

    /**
     * Helper function to format the response with the token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'message' => 'Login Success.',
            'token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }

    public function me(){

        $user = app('auth')->user();

        if($user){
            return response()->json([
                'success' => true,
                'message' => 'User profile found.',
                'data' => $user,
            ],200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Credential.',
        ],404);
    }
}
