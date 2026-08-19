<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Koreksi & <span class="text-[#5c54d8]">Riwayat Ujian</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f4f7fe] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Alert Success -->
            @if(session('success'))
                <div class="p-5 bg-green-50 border border-green-200 text-green-700 rounded-2xl shadow-sm flex items-center gap-3 font-medium">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabel Menunggu Koreksi -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-gray-50 flex justify-between items-center bg-gradient-to-r from-red-50/50 to-white">
                    <div>
                        <h3 class="text-xl font-black text-gray-800 mb-1">Menunggu Koreksi Guru</h3>
                        <p class="text-sm text-gray-500 font-medium">Daftar ujian dengan tipe soal essay yang belum dinilai.</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full hidden sm:flex items-center justify-center text-red-500 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-[10px] text-red-600 uppercase bg-red-50/50 font-black tracking-widest border-b border-red-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 whitespace-nowrap">Nama Siswa</th>
                                <th scope="col" class="px-6 py-4 whitespace-nowrap">Ujian</th>
                                <th scope="col" class="px-6 py-4 text-center whitespace-nowrap">Nilai PG Sementara</th>
                                <th scope="col" class="px-6 py-4 text-center whitespace-nowrap">Status</th>
                                <th scope="col" class="px-6 py-4 text-right whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($menungguKoreksi as $hasil)
                                <tr class="bg-white hover:bg-[#f4f7fe]/50 transition-colors">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <p class="font-bold text-gray-900 text-sm">{{ $hasil->user->name }}</p>
                                        <p class="text-[11px] font-bold text-[#5c54d8] mt-1 bg-indigo-50 px-2 py-0.5 rounded-md inline-block">
                                            Kelas {{ $hasil->user->kelas ?? '-' }} {{ $hasil->user->jurusan ?? '' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-5 font-semibold text-gray-700 whitespace-nowrap">
                                        {{ $hasil->ujian->judul_ujian }}
                                    </td>
                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 font-bold text-sm">
                                            {{ $hasil->nilai_akhir }} Poin
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <span class="inline-block px-3 py-1.5 bg-orange-50 border border-orange-100 text-orange-600 text-[10px] font-black rounded-lg uppercase tracking-wider">
                                            Perlu Dikoreksi
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right whitespace-nowrap">
                                        <a href="{{ route('koreksi.nilai', $hasil->id) }}" class="inline-block bg-[#5c54d8] hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded-xl transition-all transform hover:-translate-y-0.5 shadow-md shadow-indigo-200 text-xs">
                                            Beri Nilai Essay
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-gray-500 font-bold">Tidak ada ujian essay yang perlu dikoreksi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Riwayat Ujian -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-gray-50 flex justify-between items-center bg-gradient-to-r from-green-50/50 to-white">
                    <div>
                        <h3 class="text-xl font-black text-gray-800 mb-1">Riwayat Ujian Selesai</h3>
                        <p class="text-sm text-gray-500 font-medium">Daftar nilai akhir siswa yang sudah dikoreksi atau murni pilihan ganda.</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full hidden sm:flex items-center justify-center text-green-500 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-[10px] text-green-600 uppercase bg-green-50/50 font-black tracking-widest border-b border-green-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 whitespace-nowrap">Nama Siswa</th>
                                <th scope="col" class="px-6 py-4 whitespace-nowrap">Ujian</th>
                                <th scope="col" class="px-6 py-4 text-center whitespace-nowrap">Total Nilai Akhir</th>
                                <th scope="col" class="px-6 py-4 text-right whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($sudahDinilai as $hasil)
                                <tr class="bg-white hover:bg-[#f4f7fe]/50 transition-colors">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <p class="font-bold text-gray-900 text-sm">{{ $hasil->user->name }}</p>
                                        <p class="text-[11px] font-bold text-[#5c54d8] mt-1 bg-indigo-50 px-2 py-0.5 rounded-md inline-block">
                                            Kelas {{ $hasil->user->kelas ?? '-' }} {{ $hasil->user->jurusan ?? '' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-5 font-semibold text-gray-700 whitespace-nowrap">
                                        {{ $hasil->ujian->judul_ujian }}
                                    </td>
                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-lg bg-green-50 border border-green-200 text-green-700 font-black text-lg shadow-sm">
                                            {{ $hasil->nilai_akhir }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right whitespace-nowrap">
                                        <span class="inline-block px-3 py-1.5 bg-green-50 border border-green-100 text-green-600 text-[10px] font-black rounded-lg uppercase tracking-wider">
                                            Selesai
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-gray-500 font-bold">Belum ada riwayat ujian yang diselesaikan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Tambahan Style CSS jika class custom-scrollbar belum ke-load global -->
    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</x-app-layout>
