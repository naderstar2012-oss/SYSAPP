<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with(['property', 'createdBy'])->get();
        return response()->json($purchases);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'propertyId' => 'nullable|exists:properties,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'purchaseDate' => 'required|date',
            'category' => 'required|string|max:100',
            'supplier' => 'nullable|string|max:255',
            'invoiceNumber' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $purchase = Purchase::create([
            ...$validated,
            'createdBy' => auth()->id(),
        ]);

        // هنا يجب أن يتم ربط المشتريات بالخزينة (Treasury) - سيتم تنفيذه في المرحلة 4

        return response()->json($purchase->load(['property', 'createdBy']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::with(['property', 'createdBy'])->findOrFail($id);
        return response()->json($purchase);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validated = $request->validate([
            'propertyId' => 'nullable|exists:properties,id',
            'description' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'purchaseDate' => 'sometimes|required|date',
            'category' => 'sometimes|required|string|max:100',
            'supplier' => 'nullable|string|max:255',
            'invoiceNumber' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $purchase->update($validated);

        return response()->json($purchase->load(['property', 'createdBy']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return response()->json(null, 204);
    }
}
