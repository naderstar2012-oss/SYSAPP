<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::with(['country', 'createdBy'])->get();
        return response()->json($properties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(['residential', 'commercial'])],
            'countryId' => 'required|exists:countries,id',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'area' => 'nullable|integer',
            'rooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'floor' => 'nullable|integer',
            'status' => ['sometimes', Rule::in(['available', 'rented', 'sold', 'maintenance'])],
            'notes' => 'nullable|string',
        ]);

        $property = Property::create([
            ...$validated,
            'createdBy' => auth()->id(),
        ]);

        return response()->json($property->load(['country', 'createdBy']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = Property::with(['country', 'createdBy'])->findOrFail($id);
        return response()->json($property);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => ['sometimes', 'required', Rule::in(['residential', 'commercial'])],
            'countryId' => 'sometimes|required|exists:countries,id',
            'city' => 'sometimes|required|string|max:100',
            'address' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'area' => 'nullable|integer',
            'rooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'floor' => 'nullable|integer',
            'status' => ['sometimes', Rule::in(['available', 'rented', 'sold', 'maintenance'])],
            'notes' => 'nullable|string',
        ]);

        $property->update($validated);

        return response()->json($property->load(['country', 'createdBy']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return response()->json(null, 204);
    }
}
