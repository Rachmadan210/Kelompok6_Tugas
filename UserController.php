<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'name' => 'required',
        ]);

        $user = User::create($validatedData);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json(['message' => 'Login successful', 'user' => $user]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();
        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json(['user' => $user]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logout successful']);
    }
}
