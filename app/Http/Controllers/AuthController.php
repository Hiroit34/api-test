<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $field = $request -> validate([
            "name" => "required|max:255",
            "email"=> "required|email|unique:users",
            "password"=> "required|confirmed",
        ]);

        $registeredUser = User::create($field);

        $token = $registeredUser->createToken($request -> name);

        return [
            "user" => $registeredUser,
            "token"=> $token->plainTextToken,
        ];
    }

    public function login(Request $request) {

        $request -> validate([
            "email"=> "required|email|exists:users",
            "password"=> "required",
        ]);

        $user = User::where("email", $request -> email)->first();

        if(!$user || !Hash::check($request -> password, $user ->password)) {
            return [
                "error"=> "Utente non esiste o le credenziali non sono corrette"
            ];
        }

        $token = $user->createToken($user -> name);

        return [
            "user" => $user,
            "token"=> $token->plainTextToken,
        ];

    }

    public function logout(Request $request) {

        $request->user()->tokens()->delete();

        return [
            "messagge" => "Logout effettuato con successo."
        ];
    }
}
