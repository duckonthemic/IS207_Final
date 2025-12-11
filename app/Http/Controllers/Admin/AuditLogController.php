<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display audit logs listing
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', 'LIKE', '%' . $request->model_type . '%');
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('model_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('user_name', 'LIKE', '%' . $request->search . '%');
            });
        }

        $logs = $query->paginate(25)->withQueryString();

        // Get unique actions for filter
        $actions = AuditLog::distinct()->pluck('action')->sort();

        // Get stats
        $stats = [
            'total' => AuditLog::count(),
            'today' => AuditLog::whereDate('created_at', today())->count(),
            'this_week' => AuditLog::where('created_at', '>=', now()->startOfWeek())->count(),
            'creates' => AuditLog::where('action', 'create')->count(),
            'updates' => AuditLog::where('action', 'update')->count(),
            'deletes' => AuditLog::where('action', 'delete')->count(),
        ];

        return view('admin.audit-logs.index', compact('logs', 'actions', 'stats'));
    }

    /**
     * Display a single audit log detail
     */
    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');
        return view('admin.audit-logs.show', compact('auditLog'));
    }

    /**
     * Clear old audit logs (older than 90 days)
     */
    public function clear(Request $request)
    {
        $days = $request->input('days', 90);
        $deleted = AuditLog::where('created_at', '<', now()->subDays($days))->delete();

        return redirect()->route('admin.audit-logs.index')
            ->with('success', "Đã xóa {$deleted} bản ghi cũ hơn {$days} ngày.");
    }
}
