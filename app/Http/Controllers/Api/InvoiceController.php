<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['contract', 'createdBy'])->get();
        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contractId' => 'required|exists:contracts,id',
            'invoiceDate' => 'required|date',
            'dueDate' => 'required|date|after_or_equal:invoiceDate',
            'amount' => 'required|numeric|min:0',
            'status' => ['sometimes', Rule::in(['pending', 'paid', 'overdue', 'cancelled'])],
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::create([
            ...$validated,
            'createdBy' => auth()->id(),
        ]);

        return response()->json($invoice->load(['contract', 'createdBy']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with(['contract', 'createdBy', 'payments'])->findOrFail($id);
        return response()->json($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'contractId' => 'sometimes|required|exists:contracts,id',
            'invoiceDate' => 'sometimes|required|date',
            'dueDate' => 'sometimes|required|date|after_or_equal:invoiceDate',
            'amount' => 'sometimes|required|numeric|min:0',
            'status' => ['sometimes', Rule::in(['pending', 'paid', 'overdue', 'cancelled'])],
            'notes' => 'nullable|string',
        ]);

        $invoice->update($validated);

        return response()->json($invoice->load(['contract', 'createdBy']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json(null, 204);
    }
}
