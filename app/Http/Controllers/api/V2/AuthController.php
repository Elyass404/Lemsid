<?php

namespace App\Http\Controllers\api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{

    public function index() {
        return response()->json(["hello"=>"You need to log in"]);
    }
    public function register(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate token for user
        $token = $user->createToken('lemsid')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Login method
    public function login(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        //delete old tokens , this is an optional step;
        $user->tokens()->delete();

        // Generate token for user
        $token = $user->createToken('lemsid')->plainTextToken;

        //generate a refresh token 
        $refreshToken = $user->createToken('lemsid')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token_type'=>'Bearer',
            'token' => $token, 
            'refresh_token'=>$refreshToken
        ],200);
    }

    // Logout method
    public function logout(Request $request)
    {
        // Revoke the token of the current user
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully']);
    }

    // Get authenticated user
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function refreshToken(Request $request){
        $request->validate([
            "refresh_token"=>"required",
        ]);

        //find the user by using refresh token 
        $user = User::whereHas('tokens', function ($query) use ($request) {
            $query->where('token', hash('sha256', $request->refresh_token));
        })->first();

        //if the user not found the show the following message;
        if (!$user) {
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }

        //delete the old token
        $user->tokens()->where('token',hash("sha256",$request->refresh_token))->delete();

        //daba let's create the token
        $token = $user->createToken('lemsid')->plainTextToken;

        //create a refresh token
        $refreshToken = $user->createToken('lemsid')->plainTextToken; 

        return response()->json([
            "user"=>$user,
            "token"=>$token,
            "refresh_token"=>$refreshToken,
            "token_type"=>"Bearer",
        ]);

    }
}
