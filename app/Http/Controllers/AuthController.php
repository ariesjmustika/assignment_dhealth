<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'formLogin', 'formRegister']]);
    }

    public function formLogin(){
        return view('auth/login');
    }

    public function formRegister(){
        return view('auth/register');
    }

    public function checkEmail()
    {
        $user = User::where('email', request('email'))->first();
        if ($user) {
            return Response::json(request('email').' is already taken');
        } else {
            return Response::json(request('email').' Username is available');
        }
    }


    public function register()
    {
        $validator = Validator::make(request()->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'))
        ]);
        if($user){
              return response()->json([
                'message' => 'Pendaftaran Berhasil!',
                'data' => $user
            ]);
        }else{
              return response()->json(['message' => 'Pendaftaran Gagal!']);
        }



    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                    'messages' => 'error',
                    'error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token,  request('email'));
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
        $data= '';
        return $this->respondWithToken(auth()->refresh(), $data);
    }

    /**
     * Get the token array structure.s
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $email)
    {
        return response()->json([
            'messages' => 'success',
            'email' => $email,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 15
        ]);
    }
}
