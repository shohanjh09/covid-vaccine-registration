<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'nid' => 'required|unique:users',
            'vaccine_center_id' => 'required|exists:vaccine_centers,id',
        ]);

        $user = User::create($validatedData);

        return redirect()->route('search', ['nid' => $user->nid]);
    }
}
