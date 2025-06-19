<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>CV Mahasiswa</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        h2 {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .profile {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .photo {
            width: 120px;
            height: 120px;
            border-radius: 100%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .left-col {
            width: 35%;
        }

        .right-col {
            width: 60%;
        }

        .contact-info,
        .prestasi {
            margin-top: 10px;
        }

        .prestasi img {
            width: 180px;
            height: auto;
            margin: 8px 8px 8px 0;
            border: 1px solid #ccc;
        }

        .prestasi-item {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #555;
        }

        .logo-iwu {
            width: 100px;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>{{ $mahasiswa->user->name }}</h1>
        <p>{{ $mahasiswa->prodi->nama }} | {{ $mahasiswa->fakultas->nama }}</p>
    </div>

    <div class="profile">
        <div class="left-col">
            @if ($mahasiswa->foto)
                <img class="photo" src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto Mahasiswa">
            @endif

            <div class="contact-info">
                <p><strong>Kontak:</strong> {{ $mahasiswa->kontak ?? '-' }}</p>
                <p><strong>Email:</strong> {{ $mahasiswa->user->email }}</p>
            </div>

            <img class="logo-iwu" src="{{ asset('images/iwu.png') }}" alt="Logo IWU">
        </div>

        <div class="right-col">
            <h2>Prestasi</h2>
            @foreach ($mahasiswa->prestasi as $p)
                @php
                    $tahunMulai = \Carbon\Carbon::parse($p->tanggal_mulai)->format('Y');
                    $tahunSelesai = \Carbon\Carbon::parse($p->tanggal_selesai)->format('Y');
                    $sertifikatKelulusan = is_string($p->berkasPrestasi->sertifikat_kelulusan)
                        ? json_decode($p->berkasPrestasi->sertifikat_kelulusan, true)
                        : $p->berkasPrestasi->sertifikat_kelulusan;
                @endphp

                <div class="prestasi-item">
                    <p><strong>{{ $p->nama_prestasi }}</strong> ({{ $tahunMulai }} - {{ $tahunSelesai }})</p>
                    <p><em>{{ $p->nama_prestasi_en }}</em></p>
                    <p><strong>Tempat:</strong> {{ $p->tempat ?? '-' }}</p>

                    @if ($p->berkasPrestasi && $p->berkasPrestasi->foto_upp)
                        <img src="{{ asset('storage/' . $p->berkasPrestasi->foto_upp) }}" alt="Sertifikat">
                    @endif

                    @if (is_array($sertifikatKelulusan))
                        @foreach ($sertifikatKelulusan as $file)
                            <img src="{{ asset('storage/' . $file) }}" alt="Sertifikat Tambahan">
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <p>"The best way to predict the future is to create it." - Abraham Lincoln</p>
        <p>I am creating my future by learning new things and making small progresses everyday.</p>
    </div>

</body>

</html>
