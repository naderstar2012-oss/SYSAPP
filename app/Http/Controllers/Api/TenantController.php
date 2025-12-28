<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with('createdBy')->get();
        return response()->json($tenants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'idNumber' => 'required|string|max:50|unique:tenants,idNumber',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $tenant = Tenant::create([
            ...$validated,
            'createdBy' => auth()->id(),
        ]);

        return response()->json($tenant->load('createdBy'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tenant = Tenant::with('createdBy')->findOrFail($id);
        return response()->json($tenant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tenant = Tenant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'idNumber' => ['sometimes', 'required', 'string', 'max:50', Rule::unique('tenants', 'idNumber')->ignore($tenant->id)],
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $tenant->update($validated);

        return response()->json($tenant->load('createdBy'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return response()->json(null, 204);
    }
}
