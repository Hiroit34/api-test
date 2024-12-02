<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if ($user) {
            return $user;
        } else {
            return [
                "message" => "Utente non trovato"
            ];
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return ["message" => "L'utente non esiste"];
        }

        $field = $request -> validate([
            "name" => "max:255",
        ]);

        $user -> update($field);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return ["message"=> "Utente eliminato con successo"];
        } else {
            return ["message"=> "L'utente non esiste"];
        }

    }
}
