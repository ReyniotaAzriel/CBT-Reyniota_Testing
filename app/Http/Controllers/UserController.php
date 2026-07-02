<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Menampilkan semua user kecuali diri sendiri (opsional) agar tidak terhapus tak sengaja
        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,guru,siswa',
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // Simpan kelas & jurusan hanya jika role-nya siswa
            'kelas' => $request->role === 'siswa' ? $request->kelas : null,
            'jurusan' => $request->role === 'siswa' ? $request->jurusan : null,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8', // Password opsional saat update
            'role' => 'required|in:admin,guru,siswa',
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'kelas' => $request->role === 'siswa' ? $request->kelas : null,
            'jurusan' => $request->role === 'siswa' ? $request->jurusan : null,
        ];

        // Hanya ubah password jika kolom password diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // Menggunakan Facade Auth agar Intelephense paham
        if (\Illuminate\Support\Facades\Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
    }

    public function cetakKartu()
    {
        // Ambil khusus data siswa saja
        $siswas = User::role('siswa')->orderBy('name', 'asc')->get();

        if ($siswas->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada data siswa untuk dicetak!');
        }

        // Siapkan PDF
        $pdf = Pdf::loadView('users.kartu_ujian', compact('siswas'));
        $pdf->setPaper('A4', 'portrait');

        // Langsung tampilkan PDF di browser (stream)
        return $pdf->stream('kartu_peserta_ujian.pdf');
    }

    public function scanPresensi($user_id)
    {
        // Ambil ujian yang paling baru/aktif saat ini
        $ujianAktif = \App\Models\Ujian::latest()->first();

        \App\Models\Kehadiran::updateOrCreate(
            ['user_id' => $user_id, 'ujian_id' => $ujianAktif->id],
            ['status' => 'hadir', 'waktu_scan' => now()]
        );

        return "<h1>Absensi Berhasil!</h1><p>Siswa sudah terdata hadir untuk ujian ini.</p>";
    }
}
