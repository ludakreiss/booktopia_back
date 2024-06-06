<?php

namespace App\Http\Controllers;

use App\Models\DataResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ErrorResponse;
use App\Models\JwtResponse;
use App\Models\SuccessResponse;
use App\Models\UserResponse;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login_post', 'register']]);
    }

    public function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json(new ErrorResponse('Unauthorized'), 401);
        }

        // Encode roles into the JWT token.
        $user = Auth::user();
        $isAdmin = $user->admin ? true : false;

        // Create a JWT token with the admin claim
        $claimToken = Auth::claims(['is_admin' => $isAdmin])->attempt($credentials);
    
        // Create a JWT response with the token and its expiration time
        $responseData = new JwtResponse($claimToken, $this->getExpiration());
    
        // Return the JWT response as a JSON object
        return response()->json(new DataResponse($responseData));
    }


    public function login_get()
    {
        $user = Auth::user();
        $responseData = new UserResponse($user);

        return response()->json(new DataResponse($responseData));
    }



    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'age' => 'required|integer|min:5',
        ]);

        DB::transaction(function() use($request) {
            /**
             * @var User
             */
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'age' => $request->age, 
                'isAdmin' => 1,
                'profile_picture' => 'default-profile.png',
            ]);

        });

        return response()->json(new SuccessResponse());
    }


    public function logout()
    {
        Auth::logout();
        return response()->json(new SuccessResponse());
    }

    public function refresh()
    {
        $responseData = new JwtResponse(Auth::refresh(), $this->getExpiration());
        return response()->json(new DataResponse($responseData));
    }

    /**
     * Returns the expiration time of the current token in seconds
     * @return int Expiration time
     */
    private function getExpiration() {
        return Auth::factory()->getTTL() * 60;
    }

}
