<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Enviara un correo de retorno que nos permita recuperar la contraseña
        $user = User::where('email', $request->email)->firstOrFail();

        if (Hash::check($request->password, $user->password)) {
            return UserResource::make($user);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 404);
        }
    }
}
