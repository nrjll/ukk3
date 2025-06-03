<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseApiController
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->sendResponse($user, 'User created successfully.', 201);
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with('roles')->find($id);

        if (!$user) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('User not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return $this->sendResponse($user, 'User updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('User not found.');
        }

        $user->delete();

        return $this->sendResponse([], 'User deleted successfully.');
    }
}