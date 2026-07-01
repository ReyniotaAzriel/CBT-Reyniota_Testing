<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            <span class="text-blue-600">Hasil</span> Ujian Saya
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Riwayat Nilai Ujian</h3>
                        <p class="text-gray-500 mt-1">Daftar nilai dari ujian yang telah Anda selesaikan.</p>
                    </div>
                    <div class="text-right hidden sm:block">
                        <p class="font-extrabold text-gray-800 text-lg">{{ auth()->user()->name }}</p>
                        <p class="text-sm font-bold text-blue-600 mt-1">
                            Kelas {{ auth()->user()->kelas ?? '-' }} {{ auth()->user()->jurusan ?? '' }}
                        </p>
                    </div>
                </div>

                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100">
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm">Nama Ujian</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm">Tanggal Selesai</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm">Status</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm text-right">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($hasilUjians as $hasil)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="py-5 font-bold text-gray-900 text-lg">
                                            {{ $hasil->ujian->judul_ujian }}
                                        </td>
                                        <td class="py-5 text-gray-600">
                                            {{ $hasil->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-5">
                                            @if($hasil->status == 'menunggu_koreksi')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Menunggu Koreksi
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-5 text-right">
                                            @if($hasil->status == 'menunggu_koreksi')
                                                <div class="text-sm text-gray-500 italic">
                                                    PG: <span class="font-bold text-gray-700">{{ $hasil->nilai_akhir }}</span><br>
                                                    <span class="text-xs">(Belum + Essay)</span>
                                                </div>
                                            @else
                                                <span class="text-3xl font-black text-blue-600">{{ $hasil->nilai_akhir }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="text-gray-500 text-lg font-medium">Anda belum menyelesaikan ujian apapun.</p>
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
    </div>
</x-app-layout>
