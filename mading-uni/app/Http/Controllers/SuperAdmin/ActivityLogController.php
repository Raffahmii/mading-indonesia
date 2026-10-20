<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with(['user', 'university']);

        if ($action = $request->query('action')) {
            $query->where('action', 'like', "%{$action}%");
        }

        if ($userId = $request->query('user_id')) {
            $query->where('user_id', $userId);
        }

        $logs = $query->latest('created_at')->paginate(30)->withQueryString();

        return view('super-admin.activity-logs.index', compact('logs'));
    }
}