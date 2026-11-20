<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    // View Patient's Medical Histories
    public function index(Request $request)
    {
        $histories = $request->user()
            ->medicalHistories()
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'medical_histories' => $histories,
        ], 200);
    }

    // Save Medical History
    public function store(Request $request)
    {
        $validated = $request->validate([
            'blood_group' => 'nullable|string|max:10',
            'previous_diseases' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'past_surgeries' => 'nullable|string',
            'family_medical_history' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $history = $request->user()
            ->medicalHistories()
            ->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Medical history saved successfully!',
            'medical_history' => $history,
        ], 201);
    }

    // Update Medical History
    public function update(Request $request, $id)
    {
        $history = $request->user()
            ->medicalHistories()
            ->findOrFail($id);

        $validated = $request->validate([
            'blood_group' => 'nullable|string|max:10',
            'previous_diseases' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'past_surgeries' => 'nullable|string',
            'family_medical_history' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $history->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Medical history updated successfully!',
            'medical_history' => $history,
        ], 200);
    }

    // Delete Medical History
    public function destroy(Request $request, $id)
    {
        $history = $request->user()
            ->medicalHistories()
            ->findOrFail($id);

        $history->delete();

        return response()->json([
            'success' => true,
            'message' => 'Medical history deleted successfully!',
        ], 200);
    }
}
