<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with(['property', 'createdBy'])->get();
        return response()->json($expenses);
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
            'expenseDate' => 'required|date',
            'category' => 'required|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $expense = Expense::create([
            ...$validated,
            'createdBy' => auth()->id(),
        ]);

        // هنا يجب أن يتم ربط المصروف بالخزينة (Treasury) - سيتم تنفيذه في المرحلة 4

        return response()->json($expense->load(['property', 'createdBy']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::with(['property', 'createdBy'])->findOrFail($id);
        return response()->json($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::findOrFail($id);

        $validated = $request->validate([
            'propertyId' => 'nullable|exists:properties,id',
            'description' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'expenseDate' => 'sometimes|required|date',
            'category' => 'sometimes|required|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $expense->update($validated);

        return response()->json($expense->load(['property', 'createdBy']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return response()->json(null, 204);
    }
}
