<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Manajemen <span class="text-blue-600">Jadwal Ujian</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r-lg shadow-sm flex items-center mb-4">
                    <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Daftar Jadwal Ujian</h3>
                        <p class="text-sm text-gray-500 mt-1">Kelola waktu, mata pelajaran, dan token keamanan ujian.</p>
                    </div>
                    <a href="{{ route('ujian.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Ujian Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center w-16">No</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100">Info Ujian</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Jadwal & Durasi</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Token Akses</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($ujian as $index => $item)
                                <tr class="hover:bg-blue-50/30 transition duration-150">
                                    <td class="px-6 py-6 text-center text-gray-500 font-bold">{{ $index + 1 }}</td>

                                    <td class="px-6 py-6">
                                        <p class="font-extrabold text-gray-900 text-lg">{{ $item->judul_ujian }}</p>
                                        <div class="flex items-center mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $item->mataPelajaran->nama_pelajaran }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal_ujian)->format('d M Y') }}</p>
                                        <p class="text-xs text-gray-500 mt-1 font-medium">{{ \Carbon\Carbon::parse($item->tanggal_ujian)->format('H:i') }} WIB</p>
                                        <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">
                                            ⏱ {{ $item->durasi_menit }} Menit
                                        </span>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        @if ($item->token)
                                            <div class="inline-flex items-center justify-center px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-xl shadow-inner">
                                                <span class="text-emerald-700 font-mono font-black text-lg tracking-[0.25em]">{{ $item->token }}</span>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center justify-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-gray-400 font-bold text-sm italic">
                                                Belum Ada
                                            </span>
                                        @endif

                                        <form action="{{ route('ujian.generate_token', $item->id) }}" method="POST" class="mt-3">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-700 uppercase tracking-wider hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition-all shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                {{ $item->token ? 'Regenerate' : 'Buat Token' }}
                                            </button>
                                        </form>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('ujian.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-sm font-bold rounded-lg transition-colors">
                                                Edit
                                            </a>
                                            <form action="{{ route('ujian.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ujian ini beserta seluruh soal di dalamnya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-800 text-sm font-bold rounded-lg transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        <p class="text-gray-500 text-lg font-medium">Belum ada jadwal ujian.</p>
                                        <p class="text-gray-400 text-sm mt-1">Klik tombol di atas untuk membuat jadwal baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
