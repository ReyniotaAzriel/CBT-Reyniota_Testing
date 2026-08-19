<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Manajemen <span class="text-[#5c54d8]">Jadwal Ujian</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f4f7fe] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">

                <!-- Premium Header Edit -->
                <div class="p-8 border-b border-gray-50 bg-gradient-to-r from-yellow-50/50 to-white flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Edit Jadwal Ujian</h3>
                        <p class="text-gray-500 text-sm mt-1">Perbarui data mata pelajaran, peserta, dan waktu ujian ini.</p>
                    </div>
                </div>

                <!-- Isi Form -->
                <div class="p-8 md:p-10">
                    <form action="{{ route('ujian.update', $ujian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Baris 1: Mapel & Judul -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <!-- Custom Dropdown Alpine: Mata Pelajaran -->
                            <div>
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                                @php
                                    $selectedMapelName = $mataPelajaran->firstWhere('id', $ujian->mata_pelajaran_id)->nama_pelajaran ?? '-- Pilih Mata Pelajaran --';
                                @endphp
                                <div class="relative" x-data="{ open: false, selected: '{{ $ujian->mata_pelajaran_id }}', selectedLabel: '{{ addslashes($selectedMapelName) }}' }">
                                    <input type="hidden" name="mata_pelajaran_id" x-model="selected" required>

                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="flex justify-between items-center w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all cursor-pointer shadow-sm">
                                        <span x-text="selectedLabel" :class="selected === '' ? 'text-gray-400' : 'font-semibold text-gray-900'"></span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" style="display: none;"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="transform opacity-0 scale-95 translate-y-[-10px]"
                                        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="transform opacity-0 scale-95 translate-y-[-10px]"
                                        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden max-h-60 overflow-y-auto custom-scrollbar">
                                        <ul class="py-1">
                                            @foreach($mataPelajaran as $mapel)
                                                <li @click="selected = '{{ $mapel->id }}'; selectedLabel = '{{ addslashes($mapel->nama_pelajaran) }}'; open = false"
                                                    class="px-5 py-3 hover:bg-yellow-50 cursor-pointer transition-colors flex items-center justify-between"
                                                    :class="selected == '{{ $mapel->id }}' ? 'bg-yellow-50 text-yellow-700' : 'text-gray-600'">
                                                    <span class="font-semibold">{{ $mapel->nama_pelajaran }}</span>
                                                    <svg x-show="selected == '{{ $mapel->id }}'" class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @error('mata_pelajaran_id')
                                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="judul_ujian" class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Judul Ujian <span class="text-red-500">*</span></label>
                                <input type="text" name="judul_ujian" id="judul_ujian" value="{{ old('judul_ujian', $ujian->judul_ujian) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors shadow-sm" required placeholder="Contoh: Ujian Tengah Semester Ganjil">
                                @error('judul_ujian')
                                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- FILTER KELAS & JURUSAN -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-yellow-50/30 rounded-2xl border border-yellow-100 relative overflow-visible mb-6">
                            <!-- Dekorasi SVG Background -->
                            <svg class="absolute right-0 bottom-0 text-yellow-100 w-32 h-32 transform translate-x-10 translate-y-10 z-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>

                            <!-- Custom Dropdown Alpine: Kelas -->
                            <div class="relative z-20">
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Target Kelas <span class="text-red-500">*</span></label>
                                @php
                                    $opsiKelas = [
                                        'Semua Kelas' => 'Semua Kelas',
                                        'X' => 'Kelas X',
                                        'XI' => 'Kelas XI',
                                        'XII' => 'Kelas XII'
                                    ];
                                    $selectedKelasLabel = $opsiKelas[$ujian->kelas] ?? 'Semua Kelas';
                                @endphp
                                <div class="relative" x-data="{ open: false, selected: '{{ $ujian->kelas }}', selectedLabel: '{{ $selectedKelasLabel }}' }">
                                    <input type="hidden" name="kelas" x-model="selected" required>

                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="flex justify-between items-center w-full bg-white border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all cursor-pointer shadow-sm">
                                        <span x-text="selectedLabel" class="font-semibold text-gray-900"></span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" style="display: none;"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="transform opacity-0 scale-95 translate-y-[-10px]"
                                        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="transform opacity-0 scale-95 translate-y-[-10px]"
                                        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden max-h-60 overflow-y-auto custom-scrollbar">
                                        <ul class="py-1">
                                            @foreach($opsiKelas as $val => $label)
                                                <li @click="selected = '{{ $val }}'; selectedLabel = '{{ $label }}'; open = false"
                                                    class="px-5 py-3 hover:bg-yellow-50 cursor-pointer transition-colors flex items-center justify-between"
                                                    :class="selected == '{{ $val }}' ? 'bg-yellow-50 text-yellow-700' : 'text-gray-600'">
                                                    <span class="font-semibold">{{ $label }}</span>
                                                    <svg x-show="selected == '{{ $val }}'" class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Dropdown Alpine: Jurusan -->
                            <div class="relative z-10">
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Target Jurusan <span class="text-red-500">*</span></label>
                                @php
                                    $opsiJurusan = [
                                        'Semua Jurusan' => 'Semua Jurusan',
                                        'RPL' => 'RPL (Rekayasa Perangkat Lunak)',
                                        'TKJ' => 'TKJ (Teknik Komputer Jaringan)',
                                        'Akuntansi' => 'Akuntansi',
                                        'Perkantoran' => 'Perkantoran'
                                    ];
                                    $selectedJurusanLabel = $opsiJurusan[$ujian->jurusan] ?? 'Semua Jurusan';
                                @endphp
                                <div class="relative" x-data="{ open: false, selected: '{{ $ujian->jurusan }}', selectedLabel: '{{ $selectedJurusanLabel }}' }">
                                    <input type="hidden" name="jurusan" x-model="selected" required>

                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="flex justify-between items-center w-full bg-white border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all cursor-pointer shadow-sm">
                                        <span x-text="selectedLabel" class="font-semibold text-gray-900"></span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" style="display: none;"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="transform opacity-0 scale-95 translate-y-[-10px]"
                                        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="transform opacity-0 scale-95 translate-y-[-10px]"
                                        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden max-h-60 overflow-y-auto custom-scrollbar">
                                        <ul class="py-1">
                                            @foreach($opsiJurusan as $val => $label)
                                                <li @click="selected = '{{ $val }}'; selectedLabel = '{{ $label }}'; open = false"
                                                    class="px-5 py-3 hover:bg-yellow-50 cursor-pointer transition-colors flex items-center justify-between"
                                                    :class="selected == '{{ $val }}' ? 'bg-yellow-50 text-yellow-700' : 'text-gray-600'">
                                                    <span class="font-semibold">{{ $label }}</span>
                                                    <svg x-show="selected == '{{ $val }}'" class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 3: Tanggal & Durasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 relative z-0">
                            <div>
                                <label for="tanggal_ujian" class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Tanggal & Waktu Mulai <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="tanggal_ujian" id="tanggal_ujian" value="{{ old('tanggal_ujian', \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('Y-m-d\TH:i')) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors shadow-sm" required>
                                @error('tanggal_ujian')
                                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="durasi_menit" class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Durasi Pengerjaan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="durasi_menit" id="durasi_menit" value="{{ old('durasi_menit', $ujian->durasi_menit) }}" min="1" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 pr-20 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors shadow-sm" required placeholder="Contoh: 90">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <span class="text-gray-400 font-bold text-sm">Menit</span>
                                    </div>
                                </div>
                                @error('durasi_menit')
                                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex justify-end border-t border-gray-50 pt-6">
                            <a href="{{ route('ujian.index') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl mr-4 hover:bg-gray-50 transition-colors shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl shadow-lg shadow-yellow-200 transition-all transform hover:-translate-y-0.5">
                                Perbarui Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahan Style CSS jika class custom-scrollbar belum ke-load global -->
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(156, 163, 175, 0.5); border-radius: 20px; }
    </style>
</x-app-layout>
