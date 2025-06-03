<?php

namespace App\Http\Controllers\Api;

use App\Models\Industri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndustriController extends BaseApiController
{
    /**
     * Display a listing of industri
     */
    public function index()
    {
        $industri = Industri::all();
        return $this->sendResponse($industri, 'Industri retrieved successfully.');
    }

    /**
     * Store a newly created industri
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string',
            'email' => 'required|email|unique:industris',
            'website' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $industri = Industri::create($request->all());

        return $this->sendResponse($industri, 'Industri created successfully.', 201);
    }

    /**
     * Display the specified industri
     */
    public function show($id)
    {
        $industri = Industri::with(['pkls.siswa', 'pkls.guru'])->find($id);

        if (!$industri) {
            return $this->sendError('Industri not found.');
        }

        return $this->sendResponse($industri, 'Industri retrieved successfully.');
    }

    /**
     * Update the specified industri
     */
    public function update(Request $request, $id)
    {
        $industri = Industri::find($id);

        if (!$industri) {
            return $this->sendError('Industri not found.');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'bidang_usaha' => 'sometimes|required|string|max:255',
            'alamat' => 'sometimes|required|string',
            'kontak' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:industris,email,' . $id,
            'website' => 'sometimes|nullable|url',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $industri->update($request->all());

        return $this->sendResponse($industri, 'Industri updated successfully.');
    }

    /**
     * Remove the specified industri
     */
    public function destroy($id)
    {
        $industri = Industri::find($id);

        if (!$industri) {
            return $this->sendError('Industri not found.');
        }

        $industri->delete();

        return $this->sendResponse([], 'Industri deleted successfully.');
    }

    /**
     * Get PKL data for specific industri
     */
    public function pkl($id)
    {
        $industri = Industri::with(['pkls.siswa', 'pkls.guru'])->find($id);

        if (!$industri) {
            return $this->sendError('Industri not found.');
        }

        return $this->sendResponse($industri->pkls, 'PKL data retrieved successfully.');
    }
}