<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notification logs.
     */
    public function index(Request $request)
    {
        $query = NotificationLog::query();

        // Filtering by type (email, sms)
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filtering by status (sent, failed, pending)
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filtering by date range
        if ($request->has('startDate') && $request->has('endDate')) {
            $query->whereBetween('created_at', [$request->input('startDate'), $request->input('endDate')]);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($logs);
    }

    /**
     * Display the specified notification log.
     */
    public function show(string $id)
    {
        $log = NotificationLog::findOrFail($id);
        return response()->json($log);
    }

    // لا نحتاج إلى store, update, destroy لأن السجل يتم إنشاؤه تلقائيًا بواسطة النظام
}
