<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekap Nilai Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN REKAP NILAI UJIAN SISWA</h2>
        <p>Aplikasi Ujian Sekolah Berbasis Komputer (CBT)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas / Jurusan</th>
                <th>Mata Ujian</th>
                <th>Status</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapNilai as $index => $hasil)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $hasil->user->name }}</td>
                <td>{{ $hasil->user->kelas ?? '-' }} {{ $hasil->user->jurusan ?? '' }}</td>
                <td>{{ $hasil->ujian->judul_ujian }}</td>
                <td class="text-center">{{ $hasil->status == 'menunggu_koreksi' ? 'Menunggu Koreksi' : 'Selesai' }}</td>
                <td class="text-center"><strong>{{ $hasil->nilai_akhir }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data nilai.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
