<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request): Response
    {
        // get all from request
        $req = $request->all();

        // validate the request
        $validator = Validator::make($req, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|confirmed'
        ]);

        // check validation
        if ($validator->fails()) {
            return Response([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => ''
            ], 400);
        }

        // check if email is registered
        if (User::where('email', $req['email'])->exists()) {
            return Response([
                'status' => 409,
                'massage' => 'your email address is already registered',
                'data' => ''
            ], 409);
        }

        // set Hash password
        $req['password'] = Hash::make($req['password']);

        // store to database
        $user = User::create($req);

        // send confirmation email
        event(new Registered($user));

        // create token
        $token = $user->createToken(env('API_AUTH_TOKEN_PASSPORT'))->accessToken;

        return Response([
            'status' => 201,
            'massage' => 'register successful',
            'data' => [
                'token' => $token
            ]
        ], 201);
    }

    /**
     * Login the user
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        // get all from request
        $req = $request->all();

        // validate the request
        $validator = Validator::make($req, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8'
        ]);

        // check validation
        if ($validator->fails()) {
            return Response([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => ''
            ], 400);
        }

        // check email and password
        if (!Auth::attempt($req)) {
            return Response([
                'status' => 403,
                'message' => 'wrong email or password',
                'data' => ''
            ], 403);
        }

        // get user from database
        $user = Auth::user();

        // create token
        $token = $user->createToken(env('API_AUTH_TOKEN_PASSPORT'))->accessToken;

        return Response([
            'status' => 200,
            'message' => 'login successful',
            'data' => [
                'token' => $token
            ]
        ], 200);
    }

    /**
     * Logout the user
     *
     * @return Response
     */
    public function logout(): Response
    {
        $user = Auth::user()->token();
        $user->revoke();

        return Response([
            'status' => 200,
            'massage' => 'logout successfully',
            'data' => ''
        ], 200);
    }
}
