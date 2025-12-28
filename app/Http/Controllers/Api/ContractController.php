<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with(['property', 'tenant', 'createdBy'])->get();
        return response()->json($contracts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'propertyId' => 'required|exists:properties,id',
            'tenantId' => 'required|exists:tenants,id',
            'contractType' => ['required', Rule::in(['rent', 'sale'])],
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'rentAmount' => 'nullable|numeric|min:0',
            'salePrice' => 'nullable|numeric|min:0',
            'paymentFrequency' => ['nullable', Rule::in(['monthly', 'quarterly', 'biannually', 'annually', 'one-time'])],
            'status' => ['sometimes', Rule::in(['active', 'expired', 'terminated', 'pending'])],
            'notes' => 'nullable|string',
        ]);

        $contract = Contract::create([
            ...$validated,
            'createdBy' => auth()->id(),
        ]);

        return response()->json($contract->load(['property', 'tenant', 'createdBy']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contract = Contract::with(['property', 'tenant', 'createdBy'])->findOrFail($id);
        return response()->json($contract);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contract = Contract::findOrFail($id);

        $validated = $request->validate([
            'propertyId' => 'sometimes|required|exists:properties,id',
            'tenantId' => 'sometimes|required|exists:tenants,id',
            'contractType' => ['sometimes', 'required', Rule::in(['rent', 'sale'])],
            'startDate' => 'sometimes|required|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'rentAmount' => 'nullable|numeric|min:0',
            'salePrice' => 'nullable|numeric|min:0',
            'paymentFrequency' => ['nullable', Rule::in(['monthly', 'quarterly', 'biannually', 'annually', 'one-time'])],
            'status' => ['sometimes', Rule::in(['active', 'expired', 'terminated', 'pending'])],
            'notes' => 'nullable|string',
        ]);

        $contract->update($validated);

        return response()->json($contract->load(['property', 'tenant', 'createdBy']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();

        return response()->json(null, 204);
    }
}
