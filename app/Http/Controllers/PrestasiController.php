<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Fakultas;
use App\Models\Ormawa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\Ukm;
use Barryvdh\DomPDF\Facade\Pdf;

class PrestasiController extends Controller
{
    protected array $bobotTingkat = [
        'Internasional' => 5,
        'Nasional'      => 4,
        'Provinsi'      => 3,
        'Kab/Kota'      => 2,
        'Lokal'         => 1,
    ];

    protected array $bobotJuara = [
        'Juara 1' => 3,
        'Juara 2' => 2,
        'Juara 3' => 1,
    ];

    public function index(Request $request)
    {
        $fakultasList = Fakultas::orderBy('nama')->get();
        $ormawaList   = Ormawa::orderBy('nama')->get();
        $prodiList    = ProgramStudi::orderBy('nama')->get();
        $ukmList = Ukm::orderBy('nama')->get();


        $search   = $request->query('search');
        $fakultas = $request->query('fakultas');
        $ormawa   = $request->query('ormawa');
        $prodi    = $request->query('prodi');
        $ukm      = $request->query('ukm'); // opsional

        $query = Prestasi::where('status', 'approved')
            ->with([
                'mahasiswa.user',
                'mahasiswa.prodi',
                'mahasiswa.fakultas',
                'mahasiswa.ormawa',
                'berkasPrestasi',
            ]);

        if ($search) {
            $query->whereHas('mahasiswa.user', fn($q) =>
            $q->where('name', 'like', "%{$search}%"));
        }

        if ($prodi) {
            $query->whereHas('mahasiswa.prodi', fn($q) =>
            $q->where('id', $prodi));
        }

        if ($fakultas) {
            $query->whereHas('mahasiswa.fakultas', fn($q) =>
            $q->where('id', $fakultas));
        }

        if ($ormawa) {
            $query->whereHas('mahasiswa.ormawa', fn($q) =>
            $q->where('id', $ormawa));
        }

        if ($ukm) {
            $query->whereHas('mahasiswa.ukm', fn($q) =>
            $q->where('id', $ukm));
        }


        $all = $query->get();
        $grouped = $all->groupBy(fn($p) => $p->mahasiswa_id);

        $cards = $grouped->map(function ($group, $mahasiswaId) {
            $p0 = $group->first();
            $m  = $p0->mahasiswa;

            $totalPrestasi = $group->count();

            // Hitung poin pakai bobot
            $poin = $group->sum(function ($prestasi) {
                $bobotTingkat = [
                    'Internasional' => 5,
                    'Nasional'      => 4,
                    'Provinsi'      => 3,
                    'Kab/Kota'      => 2,
                    'Lokal'         => 1,
                ];
                $bobotJuara = [
                    'Juara 1' => 3,
                    'Juara 2' => 2,
                    'Juara 3' => 1,
                ];

                return ($bobotTingkat[$prestasi->tingkat] ?? 0)
                    * ($bobotJuara[$prestasi->jenis_juara] ?? 0);
            });

            return [
                'id'              => $mahasiswaId,
                'nama'            => $m->user->name,
                'nim'             => $m->nim,
                'jurusan'         => $m->fakultas->nama,
                'prodi'           => $m->prodi->nama,
                'totalPrestasi'   => $totalPrestasi,
                'poin'            => $poin,
                'foto' => $m->foto_mahasiswa
                    ? asset('storage/' . $m->foto_mahasiswa)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($m->user->name),
                'daftarPrestasi'  => $group->pluck('nama_prestasi')->all(),
            ];
        })->values();

        // PAGINASI
        $currentPage = request()->get('page', 1);
        $perPage = 9;
        $pagedItems = $cards->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedItems,
            $cards->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('prestasi', [
            'mahasiswa'    => $paginator,
            'fakultasList' => $fakultasList,
            'ormawaList'   => $ormawaList,
            'prodiList'    => $prodiList,
            'ukmList'      => $ukmList,
            'filters'      => compact('search', 'fakultas', 'ormawa', 'ukm', 'prodi'),
        ]);
    }

    public function show($mahasiswaId)
    {
        $prestasiList = Prestasi::where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'approved')
            ->with([
                'mahasiswa.user',
                'mahasiswa.fakultas',
                'mahasiswa.prodi',
                'mahasiswa.ormawa',
                'berkasPrestasi'
            ])
            ->orderByDesc('tahun')
            ->get();

        if ($prestasiList->isEmpty()) {
            abort(404);
        }

        $mahasiswa = $prestasiList->first()->mahasiswa;

        return view('prestasi-detail', [
            'mahasiswa'     => $mahasiswa,
            'prestasiList'  => $prestasiList,
        ]);
    }

    public function exportPDF($mahasiswaId)
    {
        $prestasiList = Prestasi::where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'approved')
            ->with(['mahasiswa.user', 'mahasiswa.fakultas', 'mahasiswa.prodi', 'berkasPrestasi'])
            ->orderByDesc('tahun')
            ->get();

        if ($prestasiList->isEmpty()) {
            abort(404);
        }

        $mahasiswa = $prestasiList->first()->mahasiswa;

        $pdf = Pdf::loadView('mahasiswa.cv-pdf', [
            'mahasiswa'     => $mahasiswa,
            'prestasiList'  => $prestasiList,
        ]);

        $dompdf = $pdf->getDomPDF();
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('chroot', public_path());

        return $pdf->stream('CV_' . $mahasiswa->user->name . '.pdf');
    }

    private function parseRange(string $range): float
    {
        if (str_starts_with($range, '<')) {
            return (float) trim($range, '<');
        }
        if (str_contains($range, '-')) {
            [$a, $b] = explode('-', $range);
            return ((float)$a + (float)$b) / 2;
        }
        return (float)$range;
    }
}
