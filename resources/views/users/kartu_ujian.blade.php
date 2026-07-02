<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Peserta Ujian</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        table.wrapper {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px;
        }

        td.card-cell {
            width: 50%;
            padding: 0;
            vertical-align: top;
        }

        .card {
            border: 2px solid #2563eb;
            border-radius: 8px;
            padding: 15px;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h3 {
            margin: 0;
            color: #1e3a8a;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 3px 0 0 0;
            font-size: 11px;
            color: #6b7280;
        }

        .content {
            width: 100%;
        }

        .content td {
            padding: 4px 0;
            font-size: 12px;
            color: #374151;
        }

        .content td.label {
            width: 30%;
            font-weight: bold;
        }

        .content td.colon {
            width: 5%;
        }

        .qrcode {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <table class="wrapper">
        <tr>
            @foreach ($siswas as $index => $siswa)
                <td class="card-cell">
                    <div class="card">
                        <div class="header">
                            <h3>KARTU PESERTA UJIAN</h3>
                            <p>Sistem Ujian Berbasis Komputer (CBT)</p>
                        </div>
                        <table class="content">
                            <tr>
                                <td class="label">Nama Lengkap</td>
                                <td class="colon">:</td>
                                <td><strong>{{ strtoupper($siswa->name) }}</strong></td>
                            </tr>
                            <tr>
                                <td class="label">Email / Login</td>
                                <td class="colon">:</td>
                                <td>{{ $siswa->email }}</td>
                            </tr>
                            <tr>
                                <td class="label">Kelas</td>
                                <td class="colon">:</td>
                                <td>{{ $siswa->kelas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Jurusan</td>
                                <td class="colon">:</td>
                                <td>{{ $siswa->jurusan ?? '-' }}</td>
                            </tr>
                        </table>
                        @php
                            // Gunakan URL dengan IP laptop agar HP bisa mengaksesnya
                            $urlPresensi = 'http://192.168.1.84:8000/presensi/scan/' . $siswa->id;
                        @endphp

                        <div class="qrcode">
                            <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(80)->generate($urlPresensi)) }}"
                                alt="QR Code">
                            <p style="font-size: 8px; margin-top: 5px;">Scan untuk Absen</p>
                        </div>
                    </div>
                </td>
                @if (($index + 1) % 2 == 0)
        </tr>
        <tr>
            @endif
            @endforeach
        </tr>
    </table>

</body>

</html>
