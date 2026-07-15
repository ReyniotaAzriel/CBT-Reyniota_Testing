<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            <span class="text-blue-600">Rekap</span> Nilai Siswa
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Data Seluruh Hasil Ujian</h3>
                        <p class="text-gray-500 mt-1">Pantau nilai dan status ujian dari semua siswa yang telah mengerjakan.</p>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto">
                        <a href="{{ route('rekap.export.excel', request()->all()) }}" class="w-full md:w-auto inline-flex justify-center items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-md transition duration-150">
                            Excel
                        </a>
                        <a href="{{ route('rekap.export.pdf', request()->all()) }}" class="w-full md:w-auto inline-flex justify-center items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-md transition duration-150">
                            PDF
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50/50 p-6 border-b border-gray-100">
                    <form action="{{ route('rekap.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full sm:w-64 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4">

                        <select name="kelas" class="w-full sm:w-48 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 py-3 px-4 text-sm">
                            <option value="">Semua Kelas</option>
                            @foreach($listKelas as $k)
                                <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                            @endforeach
                        </select>

                        <select name="jurusan" class="w-full sm:w-56 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 py-3 px-4 text-sm">
                            <option value="">Semua Jurusan</option>
                            @foreach($listJurusan as $j)
                                <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md transition-colors">
                            Filter
                        </button>
                    </form>
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
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm text-right">Nilai</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase tracking-wider text-sm text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($rekapNilai as $hasil)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="py-5">
                                            <p class="font-bold text-gray-900 text-lg">{{ $hasil->user->name }}</p>
                                            <p class="text-sm text-gray-500">Kelas {{ $hasil->user->kelas ?? '-' }} {{ $hasil->user->jurusan ?? '' }}</p>
                                        </td>
                                        <td class="py-5 text-gray-800 font-medium">{{ $hasil->ujian->judul_ujian }}</td>
                                        <td class="py-5 text-gray-600">{{ $hasil->created_at->format('d M Y, H:i') }}</td>
                                        <td class="py-5">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $hasil->status == 'menunggu_koreksi' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $hasil->status == 'menunggu_koreksi' ? 'Menunggu Koreksi' : 'Selesai' }}
                                            </span>
                                        </td>
                                        <td class="py-5 text-right font-black text-blue-600 text-2xl">{{ $hasil->nilai_akhir }}</td>
                                        <td class="py-5 text-center">
                                            <a href="{{ route('rekap.detail', $hasil->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-bold rounded-lg transition-colors">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-500">Belum ada data tersedia.</td>
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
