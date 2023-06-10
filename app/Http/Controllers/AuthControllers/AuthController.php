<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Validation\SignupValidation;
use App\Http\Validation\LoginValidation;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function storeUser(Request $request) {
        $data = $request->all();
        $validator = SignupValidation::validate($data);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
         $User= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(80),
            'photo' => isset($data['photo']) ? $data['photo'] : "",
        ]);
        return response()->json($User, 200);
    }
    public function loginUser(Request $request) {
        $data = $request->all();
        $validator = LoginValidation::validate($data);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $userData = User::select()->where('email', '=', $data['email'])->first();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            // Authentication successful
            return response()->json(['message' => 'Login successful','user' => $userData]);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function authenticate(Request $request)
    {
        $token = $request->input('token');
        // Find the user with the given token
        $user = User::where('api_token', $token)->first();
        // Check if the user exists
        if ($user) {
            // Log in the user
            Auth::login($user);
            // Redirect or return a response indicating successful authentication
            return $user;
        } else {
            // Return a response indicating failed authentication
            return response()->json(['message' => 'Invalid token'], 401);
        }
    }
    public function deleteUser($email)
    {
        $userData = User::where(function ($query) use ($email) {
                $query->orWhere('email', 'like', '%' . $email . '%');
        })->get()->first();
        if ($userData) {
            User::find($userData['id'])->delete();
            return response()->json(['message' => 'Delete successful', "user" => $userData], 200);
        } else {
            // Authentication failed
            return response()->json(['Error' => 'Delete Failed', 'message' => 'User Not Found'], 200);
        }
    }

    public function getUser($email)
    {
        $userData = User::where(function ($query) use ($email) {
                $query->orWhere('email', 'like', '%' . $email . '%');
        })->get()->first();
        if ($userData) {
            return response()->json(["user" => $userData], 200);
        } else {
            return response()->json(['message' => 'User Not Found'], 200);
        }
    }

    public function getAllUsers()
    {
        $users = User::all();
        if ($users) {
            return response()->json([$users], 200);
        } else {
            return response()->json(['message' => 'User Not Found'], 200);
        }
    }
}
