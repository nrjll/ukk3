<?php

namespace App\Http\Controllers\Api;

use App\Models\Pkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PklController extends BaseApiController
{
    /**
     * Display a listing of pkl
     */
    public function index()
    {
        $pkl = Pkl::with(['siswa', 'guru', 'industri'])->get();
        
        // Add durasi attribute to each pkl
        $pkl = $pkl->map(function ($item) {
            $item->durasi = $item->durasi;
            return $item;
        });

        return $this->sendResponse($pkl, 'PKL retrieved successfully.');
    }

    /**
     * Store a newly created pkl
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_id' => 'required|exists:gurus,id',
            'siswa_id' => 'required|exists:siswas,id',
            'industri_id' => 'required|exists:industris,id',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $pkl = Pkl::create($request->all());
        $pkl->load(['siswa', 'guru', 'industri']);
        $pkl->durasi = $pkl->durasi;

        return $this->sendResponse($pkl, 'PKL created successfully.', 201);
    }

    /**
     * Display the specified pkl
     */
    public function show($id)
    {
        $pkl = Pkl::with(['siswa', 'guru', 'industri'])->find($id);

        if (!$pkl) {
            return $this->sendError('PKL not found.');
        }

        $pkl->durasi = $pkl->durasi;

        return $this->sendResponse($pkl, 'PKL retrieved successfully.');
    }

    /**
     * Update the specified pkl
     */
    public function update(Request $request, $id)
    {
        $pkl = Pkl::find($id);

        if (!$pkl) {
            return $this->sendError('PKL not found.');
        }

        $validator = Validator::make($request->all(), [
            'guru_id' => 'sometimes|required|exists:gurus,id',
            'siswa_id' => 'sometimes|required|exists:siswas,id',
            'industri_id' => 'sometimes|required|exists:industris,id',
            'mulai' => 'sometimes|required|date',
            'selesai' => 'sometimes|required|date|after:mulai',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $pkl->update($request->all());
        $pkl->load(['siswa', 'guru', 'industri']);
        $pkl->durasi = $pkl->durasi;

        return $this->sendResponse($pkl, 'PKL updated successfully.');
    }

    /**
     * Remove the specified pkl
     */
    public function destroy($id)
    {
        $pkl = Pkl::find($id);

        if (!$pkl) {
            return $this->sendError('PKL not found.');
        }

        $pkl->delete();

        return $this->sendResponse([], 'PKL deleted successfully.');
    }
}