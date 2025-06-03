<?php

namespace App\Http\Controllers\Api;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends BaseApiController
{
    /**
     * Display a listing of guru
     */
    public function index()
    {
        $guru = Guru::all();
        return $this->sendResponse($guru, 'Guru retrieved successfully.');
    }

    /**
     * Store a newly created guru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus',
            'gender' => 'required|in:L,P',
            'alamat' => 'required|string',
            'kontak' => 'required|string',
            'email' => 'required|email|unique:gurus',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $guru = Guru::create($request->all());

        return $this->sendResponse($guru, 'Guru created successfully.', 201);
    }

    /**
     * Display the specified guru
     */
    public function show($id)
    {
        $guru = Guru::with(['pkls.siswa', 'pkls.industri'])->find($id);

        if (!$guru) {
            return $this->sendError('Guru not found.');
        }

        return $this->sendResponse($guru, 'Guru retrieved successfully.');
    }

    /**
     * Update the specified guru
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return $this->sendError('Guru not found.');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'nip' => 'sometimes|required|string|unique:gurus,nip,' . $id,
            'gender' => 'sometimes|required|in:L,P',
            'alamat' => 'sometimes|required|string',
            'kontak' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:gurus,email,' . $id,
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $guru->update($request->all());

        return $this->sendResponse($guru, 'Guru updated successfully.');
    }

    /**
     * Remove the specified guru
     */
    public function destroy($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return $this->sendError('Guru not found.');
        }

        $guru->delete();

        return $this->sendResponse([], 'Guru deleted successfully.');
    }

    /**
     * Get PKL data for specific guru
     */
    public function pkl($id)
    {
        $guru = Guru::with(['pkls.siswa', 'pkls.industri'])->find($id);

        if (!$guru) {
            return $this->sendError('Guru not found.');
        }

        return $this->sendResponse($guru->pkls, 'PKL data retrieved successfully.');
    }
}