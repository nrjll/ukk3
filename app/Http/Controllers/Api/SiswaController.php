<?php

namespace App\Http\Controllers\Api;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends BaseApiController
{
    /**
     * Display a listing of siswa
     */
    public function index()
    {
        $siswa = Siswa::with('user')->get();
        return $this->sendResponse($siswa, 'Siswa retrieved successfully.');
    }

    /**
     * Store a newly created siswa
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:siswas',
            'gender' => 'required|in:L,P',
            'alamat' => 'required|string',
            'kontak' => 'required|string',
            'email' => 'required|email|unique:siswas',
            'status_lapor_pkl' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $siswa = Siswa::create($request->all());

        return $this->sendResponse($siswa, 'Siswa created successfully.', 201);
    }

    /**
     * Display the specified siswa
     */
    public function show($id)
    {
        $siswa = Siswa::with(['user', 'pkls.guru', 'pkls.industri'])->find($id);

        if (!$siswa) {
            return $this->sendError('Siswa not found.');
        }

        return $this->sendResponse($siswa, 'Siswa retrieved successfully.');
    }

    /**
     * Update the specified siswa
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return $this->sendError('Siswa not found.');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'nis' => 'sometimes|required|string|unique:siswas,nis,' . $id,
            'gender' => 'sometimes|required|in:L,P',
            'alamat' => 'sometimes|required|string',
            'kontak' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:siswas,email,' . $id,
            'status_lapor_pkl' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $siswa->update($request->all());

        return $this->sendResponse($siswa, 'Siswa updated successfully.');
    }

    /**
     * Remove the specified siswa
     */
    public function destroy($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return $this->sendError('Siswa not found.');
        }

        $siswa->delete();

        return $this->sendResponse([], 'Siswa deleted successfully.');
    }

    /**
     * Get PKL data for specific siswa
     */
    public function pkl($id)
    {
        $siswa = Siswa::with(['pkls.guru', 'pkls.industri'])->find($id);

        if (!$siswa) {
            return $this->sendError('Siswa not found.');
        }

        return $this->sendResponse($siswa->pkls, 'PKL data retrieved successfully.');
    }
}