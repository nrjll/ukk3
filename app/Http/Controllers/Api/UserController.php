<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

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

        // Cek apakah email ada di tabel siswa
        $this->assignSiswaRoleIfExists($user, $request->email);

        // Load ulang user dengan roles untuk response
        $user->load('roles');

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

        $oldEmail = $user->email;
        
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Jika email berubah, cek apakah email baru ada di tabel siswa
        if ($request->email && $request->email !== $oldEmail) {
            $this->assignSiswaRoleIfExists($user, $request->email);
        }

        // Load ulang user dengan roles untuk response
        $user->load('roles');

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

    /**
     * Assign role siswa jika email ada di tabel siswa
     */
    private function assignSiswaRoleIfExists(User $user, string $email)
    {
        // Cek apakah email ada di tabel siswa
        $siswa = Siswa::where('email', $email)->first();
        
        if ($siswa) {
            // Pastikan role 'siswa' ada
            $siswaRole = Role::firstOrCreate(['name' => 'siswa']);
            
            // Assign role siswa ke user jika belum punya
            if (!$user->hasRole('siswa')) {
                $user->assignRole('siswa');
            }
        }
    }
}