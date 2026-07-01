<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Koreksi & Riwayat Ujian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-red-600 mb-4">Menunggu Koreksi Guru (Ada Essay)</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-red-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3">Ujian</th>
                                    <th scope="col" class="px-6 py-3">Nilai PG Sementara</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($menungguKoreksi as $hasil)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900 text-base">{{ $hasil->user->name }}</p>
                                            <p class="text-xs font-semibold text-blue-600 mt-1">
                                                Kelas {{ $hasil->user->kelas ?? '-' }} {{ $hasil->user->jurusan ?? '' }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4">{{ $hasil->ujian->judul_ujian }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-700">{{ $hasil->nilai_akhir }} Poin</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Perlu Dikoreksi</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('koreksi.nilai', $hasil->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2 transition duration-150">
                                                Beri Nilai Essay
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 font-medium">
                                            Tidak ada ujian essay yang perlu dikoreksi saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-green-600 mb-4">Riwayat Ujian Selesai (Nilai Final)</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-green-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3">Ujian</th>
                                    <th scope="col" class="px-6 py-3">Total Nilai Akhir</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sudahDinilai as $hasil)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-gray-900 text-base">{{ $hasil->user->name }}</p>
                                            <p class="text-xs font-semibold text-blue-600 mt-1">
                                                Kelas {{ $hasil->user->kelas ?? '-' }} {{ $hasil->user->jurusan ?? '' }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4">{{ $hasil->ujian->judul_ujian }}</td>
                                        <td class="px-6 py-4 font-bold text-green-600 text-lg">{{ $hasil->nilai_akhir }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Selesai</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-6 text-center text-gray-500 font-medium">
                                            Belum ada riwayat ujian yang diselesaikan.
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
