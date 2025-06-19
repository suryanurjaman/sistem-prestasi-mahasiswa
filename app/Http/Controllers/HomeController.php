<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Data statistik sama kayak di StatistikController
        $fakultasCounts = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.fakultas')
            ->with('mahasiswa.fakultas')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->fakultas->nama)
            ->map->count();

        $prodiCounts = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.prodi')
            ->with('mahasiswa.prodi')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->prodi->nama)
            ->map->count();

        $ormawaCounts = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.ormawa')
            ->with('mahasiswa.ormawa')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->ormawa->nama)
            ->map->count();

        $tahunCounts = Prestasi::where('status', 'approved')
            ->whereNotNull('tanggal_mulai')
            ->get()
            ->groupBy(fn($p) => Carbon::parse($p->tanggal_mulai)->format('Y'))
            ->map->count()
            ->sortKeys();

        // Hitung poin per kategori
        $bobotTingkat = ['Internasional' => 5, 'Nasional' => 4, 'Provinsi' => 3, 'Kab/Kota' => 2, 'Lokal' => 1];
        $bobotJuara   = ['Juara 1' => 3, 'Juara 2' => 2, 'Juara 3' => 1];

        $fakultasCards = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.fakultas')
            ->with('mahasiswa.fakultas')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->fakultas->nama)
            ->map(function ($group, $key) use ($bobotTingkat, $bobotJuara) {
                $poin = 0;
                foreach ($group as $p) {
                    $poin += ($bobotTingkat[$p->tingkat] ?? 0) * ($bobotJuara[$p->jenis_juara] ?? 0);
                }
                return [
                    'name' => $key,
                    'point' => $poin,
                ];
            })
            ->sortByDesc('point')
            ->values();

        $prodiCards = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.prodi')
            ->with('mahasiswa.prodi')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->prodi->nama)
            ->map(function ($group, $key) use ($bobotTingkat, $bobotJuara) {
                $poin = 0;
                foreach ($group as $p) {
                    $poin += ($bobotTingkat[$p->tingkat] ?? 0) * ($bobotJuara[$p->jenis_juara] ?? 0);
                }
                return [
                    'name' => $key,
                    'point' => $poin,
                ];
            })
            ->sortByDesc('point')
            ->values();

        $ormawaCards = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.ormawa')
            ->with('mahasiswa.ormawa')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->ormawa->nama)
            ->map(function ($group, $key) use ($bobotTingkat, $bobotJuara) {
                $poin = 0;
                foreach ($group as $p) {
                    $poin += ($bobotTingkat[$p->tingkat] ?? 0) * ($bobotJuara[$p->jenis_juara] ?? 0);
                }
                return [
                    'name' => $key,
                    'point' => $poin,
                ];
            })
            ->sortByDesc('point')
            ->values();

        $ukmCards = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.ukm')
            ->with('mahasiswa.ukm')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->ukm->nama)
            ->map(function ($group, $key) use ($bobotTingkat, $bobotJuara) {
                $poin = 0;
                foreach ($group as $p) {
                    $poin += ($bobotTingkat[$p->tingkat] ?? 0) * ($bobotJuara[$p->jenis_juara] ?? 0);
                }
                return [
                    'name' => $key,
                    'point' => $poin,
                ];
            })
            ->sortByDesc('point')
            ->values();

        $ukmCounts = Prestasi::where('status', 'approved')
            ->whereHas('mahasiswa.ukm')
            ->with('mahasiswa.ukm')
            ->get()
            ->groupBy(fn($p) => $p->mahasiswa->ukm->nama)
            ->map->count();


        return view('home', compact(
            'fakultasCounts',
            'prodiCounts',
            'ormawaCounts',
            'tahunCounts',
            'fakultasCards',
            'prodiCards',
            'ormawaCards',
            'ukmCards',
            'ukmCounts'
        ));
    }
}
