<?php

namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $idToken = $request->input("idToken");

//        $token = auth()->setTTL(7200)->attempt($credentials);


        $client = new Google_Client(['client_id' => env("CLIENT_ID")]);
        $payload = $client->verifyIdToken($idToken);
        if ($payload) {
            $userid = $payload['sub'];
            // If request specified a G Suite domain:
            //$domain = $payload['hd'];
        } else {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {

            /* Create the user */
            $user_data = $request->input("user");
            User::create([
                'name' => $user_data["displayName"],
                'email' => $request->get("email"),
                'password' => Hash::make($request->get("password"))
            ]);

            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL()
        ]);
    }
}
