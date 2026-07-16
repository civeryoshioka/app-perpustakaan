<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Menampilkan statistik ringkas dashboard dengan mengonsumsi endpoint
     * GET /api/stats milik aplikasi sendiri lewat Laravel HTTP Client.
     *
     * Sengaja memanggil instance server KEDUA (services.internal_api.base_url,
     * default port 8011) bukan url('/api/stats') di port server utama —
     * `php artisan serve` memproses satu request per waktu, jadi Http::get()
     * balik ke port yang sama akan deadlock: request luar menunggu request
     * dalam, padahal request dalam tidak akan pernah diproses selama server
     * masih sibuk menangani request luar itu sendiri.
     *
     * Http::get() melempar ConnectionException (bukan cuma mengembalikan
     * response gagal) kalau server tujuan sama sekali tidak bisa dihubungi —
     * misalnya server kedua belum dinyalakan. try/catch di sini memastikan
     * Dashboard tetap tampil dengan statistik nol alih-alih error 500.
     */
    public function index()
    {
        $stats = [
            'total_buku' => 0,
            'total_anggota' => 0,
            'peminjaman_aktif' => 0,
        ];

        try {
            $response = Http::get(config('services.internal_api.base_url').'/api/stats');

            if ($response->successful()) {
                $stats = $response->json();
            }
        } catch (ConnectionException $e) {
            // Server internal API (port 8011) tidak bisa dihubungi — statistik tetap tampil nol.
        }

        return view('dashboard', compact('stats'));
    }
}
