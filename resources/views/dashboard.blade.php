<x-app-layout>
    <!-- Header Title -->
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Dashboard <span class="text-[#5c54d8]">Utama</span>
        </h2>
    </x-slot>

    <!-- Wrapper utama dengan Alpine.js -->
    <div x-data="{ showSystemModal: false }" class="py-8 bg-[#f4f7fe] min-h-screen relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- 1. STATISTIC CARDS (Baris Atas) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Card Total Siswa -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Siswa</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ number_format($totalSiswa ?? 0) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Card Total Guru -->
                <div
                    class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tenaga Pengajar</p>
                        <h3 class="text-2xl font-black text-gray-900">{{ number_format($totalGuru ?? 0) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Card Menunggu Koreksi -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Perlu Dikoreksi</p>
                        <h3 class="text-2xl font-black text-amber-600">{{ number_format($menungguKoreksiCount ?? 0) }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Card Ujian Selesai -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Ujian Selesai</p>
                        <h3 class="text-2xl font-black text-emerald-600">{{ number_format($ujianSelesai ?? 0) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 2. GRID UTAMA (KIRI: GRAFIK & TABEL, KANAN: PROFIL & AKTIVITAS) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- KIRI (Kolom 1 & 2): Grafik Aktivitas & Tabel Jadwal -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- KARTU GRAFIK AKTIVITAS SISWA (PERBAIKAN SKALA) -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h4 class="font-black text-gray-900 text-lg">Grafik Aktivitas Ujian</h4>
                                <p class="text-xs text-gray-400 font-medium mt-0.5">Statistik jumlah peserta dan
                                    rata-rata nilai siswa per ujian.</p>
                            </div>
                            <div class="flex items-center gap-4 text-xs font-bold">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-3 h-3 rounded-full bg-[#5c54d8] inline-block"></span>
                                    <span class="text-gray-600">Peserta Ujian</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                                    <span class="text-gray-600">Rata-rata Nilai (Skala 100)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Visualisasi Grafik dengan Skala Proporsional -->
                        <!-- Visualisasi Grafik Aktivitas -->
                        <div class="relative w-full h-[350px]" x-data="{
                            labels: @js($labelsGrafik),
                            peserta: @js($pesertaGrafik),
                            rataRata: @js($rataRataGrafik),

                            getMaxPeserta() {
                                let max = Math.max(...this.peserta);
                                return max > 0 ? max : 10;
                            },

                            getBarHeightPeserta(index) {
                                return Math.max(
                                    (this.peserta[index] / this.getMaxPeserta()) * 100,
                                    this.peserta[index] > 0 ? 8 : 0
                                );
                            },

                            getBarHeightNilai(index) {
                                return Math.max(
                                    this.rataRata[index],
                                    this.rataRata[index] > 0 ? 8 : 0
                                );
                            }
                        }">
                            @if (count($labelsGrafik) > 0)
                                <!-- Chart Area -->
                                <div class="absolute inset-0 flex">

                                    <!-- Y Axis -->
                                    <div class="w-12 flex flex-col justify-between pb-12 pt-2 pr-2">
                                        <span class="text-[10px] font-semibold text-gray-400 text-right">100</span>
                                        <span class="text-[10px] font-semibold text-gray-400 text-right">75</span>
                                        <span class="text-[10px] font-semibold text-gray-400 text-right">50</span>
                                        <span class="text-[10px] font-semibold text-gray-400 text-right">25</span>
                                        <span class="text-[10px] font-semibold text-gray-400 text-right">0</span>
                                    </div>

                                    <!-- Main Graph -->
                                    <div class="relative flex-1">

                                        <!-- Horizontal Grid -->
                                        <div
                                            class="absolute inset-x-0 top-2 bottom-12 flex flex-col justify-between pointer-events-none">
                                            <div class="border-t border-gray-100"></div>
                                            <div class="border-t border-dashed border-gray-100"></div>
                                            <div class="border-t border-dashed border-gray-100"></div>
                                            <div class="border-t border-dashed border-gray-100"></div>
                                            <div class="border-t border-gray-200"></div>
                                        </div>

                                        <!-- Bars -->
                                        <div
                                            class="absolute inset-x-0 top-2 bottom-0 flex items-end justify-around gap-4 px-4">

                                            <template x-for="(label, index) in labels" :key="index">

                                                <div
                                                    class="flex-1 max-w-[160px] h-full flex flex-col items-center justify-end group">

                                                    <!-- Tooltip -->
                                                    <div
                                                        class="
                                absolute
                                -translate-y-2
                                bg-gray-900
                                text-white
                                rounded-xl
                                px-3
                                py-2
                                text-[10px]
                                shadow-xl
                                opacity-0
                                group-hover:opacity-100
                                transition-all
                                duration-200
                                pointer-events-none
                                z-30
                            ">
                                                        <div class="font-bold text-white mb-1">
                                                            <span x-text="label"></span>
                                                        </div>

                                                        <div class="flex items-center gap-2">
                                                            <span class="text-indigo-300">
                                                                ● Peserta:
                                                                <span class="text-white font-black"
                                                                    x-text="peserta[index]"></span>
                                                            </span>
                                                        </div>

                                                        <div class="flex items-center gap-2">
                                                            <span class="text-emerald-300">
                                                                ● Nilai:
                                                                <span class="text-white font-black"
                                                                    x-text="rataRata[index]"></span>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Value Labels -->
                                                    <div class="flex items-end justify-center gap-3 h-[250px] w-full">

                                                        <!-- Peserta -->
                                                        <div class="relative h-full flex items-end justify-center w-10">

                                                            <span
                                                                class="
                                            absolute
                                            -top-6
                                            text-[10px]
                                            font-black
                                            text-indigo-600
                                            opacity-0
                                            group-hover:opacity-100
                                            transition-opacity
                                        "
                                                                x-text="peserta[index]"></span>

                                                            <div class="
                                            w-8
                                            rounded-t-xl
                                            bg-gradient-to-t
                                            from-indigo-600
                                            to-indigo-400
                                            shadow-md
                                            transition-all
                                            duration-300
                                            group-hover:scale-x-110
                                            group-hover:shadow-lg
                                        "
                                                                :style="`height: ${getBarHeightPeserta(index)}%`"></div>

                                                        </div>

                                                        <!-- Nilai -->
                                                        <div class="relative h-full flex items-end justify-center w-10">

                                                            <span
                                                                class="
                                            absolute
                                            -top-6
                                            text-[10px]
                                            font-black
                                            text-emerald-600
                                            opacity-0
                                            group-hover:opacity-100
                                            transition-opacity
                                        "
                                                                x-text="rataRata[index]"></span>

                                                            <div class="
                                            w-8
                                            rounded-t-xl
                                            bg-gradient-to-t
                                            from-emerald-500
                                            to-emerald-300
                                            shadow-md
                                            transition-all
                                            duration-300
                                            group-hover:scale-x-110
                                            group-hover:shadow-lg
                                        "
                                                                :style="`height: ${getBarHeightNilai(index)}%`"></div>

                                                        </div>

                                                    </div>

                                                    <!-- Bottom Labels -->
                                                    <div class="mt-4 w-full text-center">

                                                        <div class="
                                        text-[11px]
                                        font-bold
                                        text-gray-600
                                        truncate
                                        px-2
                                    "
                                                            :title="label" x-text="label"></div>

                                                    </div>

                                                </div>

                                            </template>

                                        </div>

                                    </div>

                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="w-full h-full flex flex-col items-center justify-center">
                                    <div
                                        class="
                w-16 h-16
                rounded-2xl
                bg-gray-50
                flex items-center justify-center
                mb-4
            ">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                    </div>

                                    <p class="text-sm font-semibold text-gray-400">
                                        Belum ada data aktivitas ujian
                                    </p>

                                    <p class="text-xs text-gray-300 mt-1">
                                        Grafik akan tampil setelah terdapat data ujian.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tabel Jadwal Ujian Mendatang -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="font-black text-gray-900 text-lg">Jadwal Ujian Mendatang</h4>
                            <a href="{{ route('ujian.index') }}"
                                class="text-xs font-bold text-[#5c54d8] hover:underline">Lihat Semua &rarr;</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead
                                    class="bg-gray-50/50 text-gray-400 text-[10px] font-black uppercase tracking-wider">
                                    <tr>
                                        <th class="px-4 py-3">Tanggal</th>
                                        <th class="px-4 py-3">Nama Ujian</th>
                                        <th class="px-4 py-3">Mata Pelajaran</th>
                                        <th class="px-4 py-3 text-center">Kelas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-sm">
                                    @forelse($jadwalMendatang as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-4 py-3.5 text-gray-500 font-semibold text-xs">
                                                {{ \Carbon\Carbon::parse($item->tanggal_ujian)->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-4 py-3.5 font-bold text-gray-800">{{ $item->judul_ujian }}
                                            </td>
                                            <td class="px-4 py-3.5 text-gray-600 font-medium">
                                                {{ $item->mataPelajaran->nama_pelajaran ?? '-' }}</td>
                                            <td class="px-4 py-3.5 text-center font-bold text-gray-600">
                                                {{ $item->kelas }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="py-8 text-center text-gray-400 text-sm font-medium">Belum ada
                                                jadwal ujian mendatang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- KANAN (Kolom 3): Widget Profil & Log Aktivitas Sistem -->
                <div class="space-y-8">

                    <!-- Widget Profile Card -->
                    <div
                        class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 text-center relative overflow-hidden">
                        <div
                            class="h-24 bg-gradient-to-r from-indigo-50 to-purple-50 absolute top-0 left-0 w-full rounded-t-3xl">
                        </div>

                        <div class="relative z-10">
                            <div class="w-20 h-20 mx-auto bg-white rounded-2xl mb-4 overflow-hidden shadow-md p-1">
                                @if (Auth::user()->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile"
                                        class="w-full h-full object-cover rounded-xl">
                                @else
                                    <div
                                        class="w-full h-full bg-[#5c54d8] text-white rounded-xl flex items-center justify-center text-3xl font-black">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <h4 class="font-bold text-gray-900 text-lg">{{ Auth::user()->name ?? 'Administrator' }}
                            </h4>
                            <p class="text-xs text-gray-400 font-bold mb-6 uppercase tracking-wider">
                                {{ Auth::user()->roles->first()->name ?? 'ADMIN' }}
                            </p>

                            <div class="space-y-4 text-left border-t border-gray-100 pt-5 mt-5">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-bold text-gray-700">Email</span>
                                    <span
                                        class="text-gray-500 truncate max-w-[160px]">{{ Auth::user()->email ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-bold text-gray-700">Status Akun</span>
                                    <span
                                        class="text-emerald-600 font-bold bg-emerald-50 px-2.5 py-1 rounded-md">Verified</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Widget Log Aktivitas Terbaru -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-5">
                            <h4 class="font-black text-gray-900 text-base">Aktivitas Terbaru</h4>
                            @if (Route::has('activity-log.index'))
                                <a href="{{ route('activity-log.index') }}"
                                    class="text-xs font-bold text-[#5c54d8] hover:underline">Semua</a>
                            @endif
                        </div>

                        <div class="space-y-4">
                            @forelse($aktivitasTerbaru ?? [] as $log)
                                <div
                                    class="flex items-start gap-3 pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                                    <div
                                        class="w-8 h-8 rounded-xl bg-indigo-50 text-[#5c54d8] flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                        {{ strtoupper(substr($log->causer->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-xs font-bold text-gray-800 truncate">
                                            {{ $log->causer->name ?? 'Sistem' }}</p>
                                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">
                                            {{ $log->description }}</p>
                                        <span
                                            class="text-[9px] font-semibold text-gray-400 mt-1 block">{{ $log->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-4">Belum ada aktivitas tercatat.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- MODAL SYSTEM OVERVIEW -->
        <div x-show="showSystemModal" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center px-4 sm:px-6">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm cursor-pointer"
                @click="showSystemModal = false"></div>

            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-xl p-6 md:p-8 overflow-hidden z-10">
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-black text-gray-800">Detail System Overview</h3>
                    <button type="button" @click="showSystemModal = false"
                        class="text-gray-400 hover:text-red-500 bg-gray-50 p-2 rounded-full cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
                        <p class="text-xs font-bold text-blue-800 uppercase">Siswa Terdaftar</p>
                        <h4 class="text-2xl font-black text-blue-900 mt-1">{{ number_format($totalSiswa ?? 0) }}</h4>
                    </div>
                    <div class="p-4 bg-green-50/50 rounded-2xl border border-green-100">
                        <p class="text-xs font-bold text-green-800 uppercase">Tenaga Pengajar</p>
                        <h4 class="text-2xl font-black text-green-900 mt-1">{{ number_format($totalGuru ?? 0) }}</h4>
                    </div>
                    <div class="p-4 bg-purple-50/50 rounded-2xl border border-purple-100">
                        <p class="text-xs font-bold text-purple-800 uppercase">Total Jadwal Ujian</p>
                        <h4 class="text-2xl font-black text-purple-900 mt-1">{{ number_format($totalUjian ?? 0) }}
                        </h4>
                    </div>
                    <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-100">
                        <p class="text-xs font-bold text-amber-800 uppercase">Mata Pelajaran</p>
                        <h4 class="text-2xl font-black text-amber-900 mt-1">{{ number_format($totalMapel ?? 0) }}</h4>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="button" @click="showSystemModal = false"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-xl text-sm transition-colors cursor-pointer">
                        Tutup Panel
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
