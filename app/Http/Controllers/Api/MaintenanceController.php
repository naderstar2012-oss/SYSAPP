<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenance = Maintenance::with(['property', 'createdBy'])->get();
        return response()->json($maintenance);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'propertyId' => 'required|exists:properties,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['repair', 'inspection', 'cleaning', 'other'])],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'status' => ['sometimes', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'cost' => 'nullable|numeric|min:0',
            'scheduledDate' => 'nullable|date',
            'completedDate' => 'nullable|date|after_or_equal:scheduledDate',
            'contractor' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $maintenance = Maintenance::create([
            ...$validated,
            'createdBy' => auth()->id(),
        ]);

        return response()->json($maintenance->load(['property', 'createdBy']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maintenance = Maintenance::with(['property', 'createdBy'])->findOrFail($id);
        return response()->json($maintenance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $validated = $request->validate([
            'propertyId' => 'sometimes|required|exists:properties,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['sometimes', 'required', Rule::in(['repair', 'inspection', 'cleaning', 'other'])],
            'priority' => ['sometimes', 'required', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'status' => ['sometimes', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'cost' => 'nullable|numeric|min:0',
            'scheduledDate' => 'nullable|date',
            'completedDate' => 'nullable|date|after_or_equal:scheduledDate',
            'contractor' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $maintenance->update($validated);

        return response()->json($maintenance->load(['property', 'createdBy']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return response()->json(null, 204);
    }
}
