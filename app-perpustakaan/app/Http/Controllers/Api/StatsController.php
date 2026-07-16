<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;

class StatsController extends Controller
{
    /**
     * Menampilkan ringkasan statistik untuk dashboard: total buku, anggota, dan peminjaman aktif.
     */
    public function index()
    {
        return response()->json([
            'total_buku' => Book::count(),
            'total_anggota' => Member::count(),
            'peminjaman_aktif' => Loan::where('status', 'dipinjam')->count(),
        ]);
    }
}
