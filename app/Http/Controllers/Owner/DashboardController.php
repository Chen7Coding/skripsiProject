<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Kita akan tambahkan logika untuk mengambil data statistik di sini nanti
        return view('owner.dashboard');
    }
}
