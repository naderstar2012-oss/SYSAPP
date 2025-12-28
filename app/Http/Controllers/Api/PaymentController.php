<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['invoice', 'createdBy'])->get();
        return response()->json($payments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoiceId' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'paymentDate' => 'required|date',
            'paymentMethod' => ['required', Rule::in(['cash', 'bank_transfer', 'cheque', 'online'])],
            'notes' => 'nullable|string',
            // 'receiptFileUrl' => 'nullable|url', // سيتم التعامل مع الملفات لاحقاً
            // 'receiptFileKey' => 'nullable|string',
        ]);

        $payment = Payment::create([
            ...$validated,
            'createdBy' => auth()->id(),
        ]);

        // هنا يجب أن يتم تحديث حالة الفاتورة (Invoice Status)
        // وهنا يجب أن يتم ربط الدفعة بالخزينة (Treasury) - سيتم تنفيذه في المرحلة 4

        return response()->json($payment->load(['invoice', 'createdBy']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with(['invoice', 'createdBy'])->findOrFail($id);
        return response()->json($payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'invoiceId' => 'sometimes|required|exists:invoices,id',
            'amount' => 'sometimes|required|numeric|min:0',
            'paymentDate' => 'sometimes|required|date',
            'paymentMethod' => ['sometimes', 'required', Rule::in(['cash', 'bank_transfer', 'cheque', 'online'])],
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);

        return response()->json($payment->load(['invoice', 'createdBy']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json(null, 204);
    }
}
