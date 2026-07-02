<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">Manajemen <span class="text-blue-600">Pengguna</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900">Daftar Pengguna Sistem</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola data Admin, Guru, dan Siswa.</p>
                </div>

                <div class="flex space-x-3">
                    <a href="{{ route('users.cetak_kartu') }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-105 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Kartu Ujian
                    </a>
                    <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:scale-105 flex items-center">
                        + Tambah Pengguna
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r-lg shadow-sm flex items-center">
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div
                    class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-lg shadow-sm flex items-center">
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-bold border-b border-gray-100">Nama & Email</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Peran (Role)</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Kelas/Jurusan</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($users as $u)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <p class="font-extrabold text-gray-900 text-base">{{ $u->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $u->email }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($u->hasRole('admin'))
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">Admin</span>
                                        @elseif($u->hasRole('guru'))
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Guru</span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full">Siswa</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-600 font-medium">
                                        {{ $u->hasRole('siswa') ? $u->kelas . ' ' . $u->jurusan : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('users.edit', $u->id) }}"
                                                class="px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-sm font-bold rounded-lg transition-colors">Edit</a>
                                            <form id="delete-form-{{ $u->id }}"
                                                action="{{ route('users.destroy', $u->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    onclick="konfirmasiHapus({{ $u->id }}, '{{ addslashes($u->name) }}')"
                                                    class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-bold rounded-lg transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function konfirmasiHapus(id, namaPengguna) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: `Data pengguna <b>${namaPengguna}</b> akan dihapus secara permanen dan tidak dapat dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Warna merah-600 Tailwind
                cancelButtonColor: '#4b5563',  // Warna gray-600 Tailwind
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true, // Membalik posisi tombol agar "Ya" di kanan
                backdrop: `rgba(0,0,0,0.6)` // Efek latar belakang gelap dramatis
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika diklik "Ya", sistem akan otomatis submit form yang sesuai dengan ID
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
