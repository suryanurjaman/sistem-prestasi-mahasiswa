<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        // Statistik per Fakultas
        $fakultasCounts = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.fakultas')     // hanya yg fakultas tidak null
            ->with('mahasiswa.fakultas')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->fakultas->nama)
            ->map->count();

        // Statistik per Prodi
        $prodiCounts = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.prodi')
            ->with('mahasiswa.prodi')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->prodi->nama)
            ->map->count();

        // Statistik per Ormawa
        $ormawaCounts = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.ormawa')
            ->with('mahasiswa.ormawa')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->ormawa->nama)
            ->map->count();

        // Statistik per Tahun
        $tahunCounts = Prestasi::where('status', 'approved')
            ->whereNotNull('tanggal_mulai')
            ->get()
            ->groupBy(fn($p) => \Carbon\Carbon::parse($p->tanggal_mulai)->format('Y'))
            ->map->count()
            ->sortKeys();

        $ukmCounts = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.ukm')
            ->with('mahasiswa.ukm')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->ukm->nama)
            ->map->count();

        return view('statistik', compact(
            'fakultasCounts',
            'prodiCounts',
            'ormawaCounts',
            'tahunCounts',
            'ukmCounts'
        ));
    }
}
