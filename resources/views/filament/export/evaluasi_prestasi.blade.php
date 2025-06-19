@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Evaluasi Prestasi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Daftar Pengajuan Prestasi</h2>
    <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th>Fakultas</th>
                <th>Nama Lomba</th>
                <th>Tempat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        @if ($item->mahasiswa->foto_mahasiswa)
                            <img src="{{ public_path('storage/' . $item->mahasiswa->foto_mahasiswa) }}" alt="foto"
                                width="40" height="40">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->mahasiswa->nim }}</td>
                    <td>{{ $item->mahasiswa->user->name }}</td>
                    <td>{{ $item->mahasiswa->prodi->nama }}</td>
                    <td>{{ $item->mahasiswa->fakultas->nama }}</td>
                    <td>{{ $item->nama_prestasi }}</td>
                    <td>{{ $item->tempat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
