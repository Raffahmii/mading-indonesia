<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('super-admin.settings.index', [
            'config' => config('mading'),
        ]);
    }

    public function update(Request $request)
    {
        // Placeholder — nanti bisa simpan ke DB settings table
        return back()->with('success', 'Settings disimpan (placeholder).');
    }
}