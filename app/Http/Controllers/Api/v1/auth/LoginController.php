<?php

namespace App\Http\Controllers\Api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->with('Roles')->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $device = substr($request->userAgent(), 0, 255);

        $token = $user->createToken(
            $device,
            ['*'],
            $request->has('remember_me') && $request->remember_me === true ? now()->addMonths(1) : now()->addSeconds(30)
        )->plainTextToken;

        return response()->json([
            'User' => $user,
            'Token' => $token,
        ]);
    }
}
