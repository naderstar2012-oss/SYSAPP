<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Purchase;
use App\Models\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport; // سنقوم بإنشاء هذا لاحقًا
use PDF; // سنقوم بإنشاء هذا لاحقًا (باستخدام dompdf أو ما شابه)

class ReportController extends Controller
{
    /**
     * Get filtered data for a specific report type.
     */
    private function getReportData(Request $request, $model)
    {
        $query = $model::query();

        // Filtering by date range
        if ($request->has('startDate') && $request->has('endDate')) {
            $query->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')]);
        }

        // Filtering by property
        if ($request->has('propertyId')) {
            $query->where('propertyId', $request->input('propertyId'));
        }

        // Filtering by category (for Expense/Purchase)
        if ($request->has('category') && ($model === Expense::class || $model === Purchase::class)) {
            $query->where('category', $request->input('category'));
        }

        return $query->with(['property', 'createdBy'])->get();
    }

    /**
     * Generate Expense Report.
     */
    public function expenseReport(Request $request)
    {
        $data = $this->getReportData($request, Expense::class);
        return response()->json($data);
    }

    /**
     * Generate Purchase Report.
     */
    public function purchaseReport(Request $request)
    {
        $data = $this->getReportData($request, Purchase::class);
        return response()->json($data);
    }

    /**
     * Generate Payment Report.
     */
    public function paymentReport(Request $request)
    {
        $data = $this->getReportData($request, Payment::class);
        return response()->json($data);
    }

    /**
     * Export a report to Excel.
     */
    public function exportExcel(Request $request, $reportType)
    {
        $model = $this->getModelFromType($reportType);
        if (!$model) {
            return response()->json(['error' => 'Invalid report type'], 400);
        }

        $data = $this->getReportData($request, $model);
        $fileName = $reportType . '_report_' . now()->format('Ymd_His') . '.xlsx';

        // يجب إنشاء ReportExport class لاحقًا
        return Excel::download(new ReportExport($data, $reportType), $fileName);
    }

    /**
     * Export a report to PDF.
     */
    public function exportPdf(Request $request, $reportType)
    {
        $model = $this->getModelFromType($reportType);
        if (!$model) {
            return response()->json(['error' => 'Invalid report type'], 400);
        }

        $data = $this->getReportData($request, $model);
        $view = 'reports.' . $reportType; // يجب إنشاء ملفات Blade لهذه التقارير لاحقًا

        // يجب تثبيت dompdf أو ما شابه لاحقًا
        // $pdf = PDF::loadView($view, ['data' => $data, 'reportType' => $reportType]);
        // return $pdf->download($reportType . '_report_' . now()->format('Ymd_His') . '.pdf');

        return response()->json(['message' => 'PDF generation logic needs PDF library installation and view creation.'], 501);
    }

    /**
     * Helper to map report type to Eloquent Model.
     */
    private function getModelFromType($reportType)
    {
        return match ($reportType) {
            'expense' => Expense::class,
            'purchase' => Purchase::class,
            'payment' => Payment::class,
            default => null,
        };
    }
}
