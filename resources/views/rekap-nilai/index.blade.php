<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            <span class="text-blue-600">Rekap</span> Nilai Siswa
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">

                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Data Seluruh Hasil Ujian</h3>
                        <p class="text-gray-500 mt-1">Pantau nilai dan status ujian dari semua siswa yang telah mengerjakan.</p>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('rekap.export.excel') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg shadow transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Excel
                        </a>
                        <a href="{{ route('rekap.export.pdf') }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg shadow transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            PDF
                        </a>
                    </div>
                </div>

                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100">
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm">Nama Siswa</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm">Mata Ujian</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm">Waktu Selesai</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm">Status</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm text-right">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($rekapNilai as $hasil)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="py-5">
                                            <p class="font-bold text-gray-900 text-lg">{{ $hasil->user->name }}</p>
                                            <p class="text-sm font-medium text-gray-500 mt-1">
                                                Kelas {{ $hasil->user->kelas ?? '-' }} {{ $hasil->user->jurusan ?? '' }}
                                            </p>
                                        </td>
                                        <td class="py-5 text-gray-800 font-medium">
                                            {{ $hasil->ujian->judul_ujian }}
                                        </td>
                                        <td class="py-5 text-gray-600">
                                            {{ $hasil->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-5">
                                            @if($hasil->status == 'menunggu_koreksi')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    Menunggu Koreksi
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-5 text-right">
                                            <span class="text-2xl font-black {{ $hasil->status == 'menunggu_koreksi' ? 'text-gray-400' : 'text-blue-600' }}">
                                                {{ $hasil->nilai_akhir }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center">
                                            <p class="text-gray-500 text-lg font-medium">Belum ada siswa yang menyelesaikan ujian.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
