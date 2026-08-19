<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Manajemen <span class="text-[#5c54d8]">Jadwal Ujian</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f4f7fe] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">

                <!-- Header Kartu -->
                <div class="p-8 border-b border-gray-50 bg-gradient-to-r from-indigo-50/50 to-white flex items-center gap-4">
                    <div class="p-3 bg-indigo-100 text-[#5c54d8] rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Tambah Jadwal Baru</h3>
                        <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah ini untuk mengatur waktu dan target peserta ujian.</p>
                    </div>
                </div>

                <!-- Isi Form -->
                <div class="p-8 md:p-10">
                    <form action="{{ route('ujian.store') }}" method="POST">
                        @csrf

                        <!-- Baris 1: Mapel & Judul -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <!-- Custom Dropdown Alpine: Mata Pelajaran -->
                            <div>
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                                <div class="relative" x-data="{ open: false, selected: '', selectedLabel: '-- Pilih Mata Pelajaran --' }">
                                    <input type="hidden" name="mata_pelajaran_id" x-model="selected" required>

                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="flex justify-between items-center w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-all cursor-pointer shadow-sm">
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
                                                    class="px-5 py-3 hover:bg-indigo-50 cursor-pointer transition-colors flex items-center justify-between"
                                                    :class="selected == '{{ $mapel->id }}' ? 'bg-indigo-50 text-[#5c54d8]' : 'text-gray-600'">
                                                    <span class="font-semibold">{{ $mapel->nama_pelajaran }}</span>
                                                    <svg x-show="selected == '{{ $mapel->id }}'" class="w-5 h-5 text-[#5c54d8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
                                <input type="text" name="judul_ujian" id="judul_ujian" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-colors shadow-sm" required placeholder="Contoh: Ujian Tengah Semester Ganjil">
                                @error('judul_ujian')
                                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- FILTER KELAS & JURUSAN -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-indigo-50/50 rounded-2xl border border-indigo-100 relative overflow-visible mb-6">
                            <!-- Dekorasi SVG Background -->
                            <svg class="absolute right-0 bottom-0 text-indigo-100 w-32 h-32 transform translate-x-10 translate-y-10 z-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>

                            <!-- Custom Dropdown Alpine: Kelas -->
                            <div class="relative z-20">
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Target Kelas <span class="text-red-500">*</span></label>
                                <div class="relative" x-data="{ open: false, selected: 'Semua Kelas', selectedLabel: 'Semua Kelas' }">
                                    <input type="hidden" name="kelas" x-model="selected" required>

                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="flex justify-between items-center w-full bg-white border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-all cursor-pointer shadow-sm">
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
                                            @php
                                                $opsiKelas = [
                                                    'Semua Kelas' => 'Semua Kelas',
                                                    'X' => 'Kelas X',
                                                    'XI' => 'Kelas XI',
                                                    'XII' => 'Kelas XII'
                                                ];
                                            @endphp
                                            @foreach($opsiKelas as $val => $label)
                                                <li @click="selected = '{{ $val }}'; selectedLabel = '{{ $label }}'; open = false"
                                                    class="px-5 py-3 hover:bg-indigo-50 cursor-pointer transition-colors flex items-center justify-between"
                                                    :class="selected == '{{ $val }}' ? 'bg-indigo-50 text-[#5c54d8]' : 'text-gray-600'">
                                                    <span class="font-semibold">{{ $label }}</span>
                                                    <svg x-show="selected == '{{ $val }}'" class="w-5 h-5 text-[#5c54d8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Dropdown Alpine: Jurusan -->
                            <div class="relative z-10">
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Target Jurusan <span class="text-red-500">*</span></label>
                                <div class="relative" x-data="{ open: false, selected: 'Semua Jurusan', selectedLabel: 'Semua Jurusan' }">
                                    <input type="hidden" name="jurusan" x-model="selected" required>

                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="flex justify-between items-center w-full bg-white border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-all cursor-pointer shadow-sm">
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
                                            @php
                                                $opsiJurusan = [
                                                    'Semua Jurusan' => 'Semua Jurusan',
                                                    'RPL' => 'RPL (Rekayasa Perangkat Lunak)',
                                                    'TKJ' => 'TKJ (Teknik Komputer Jaringan)',
                                                    'Akuntansi' => 'Akuntansi',
                                                    'Perkantoran' => 'Perkantoran'
                                                ];
                                            @endphp
                                            @foreach($opsiJurusan as $val => $label)
                                                <li @click="selected = '{{ $val }}'; selectedLabel = '{{ $label }}'; open = false"
                                                    class="px-5 py-3 hover:bg-indigo-50 cursor-pointer transition-colors flex items-center justify-between"
                                                    :class="selected == '{{ $val }}' ? 'bg-indigo-50 text-[#5c54d8]' : 'text-gray-600'">
                                                    <span class="font-semibold">{{ $label }}</span>
                                                    <svg x-show="selected == '{{ $val }}'" class="w-5 h-5 text-[#5c54d8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
                                <input type="datetime-local" name="tanggal_ujian" id="tanggal_ujian" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-colors shadow-sm" required>
                                @error('tanggal_ujian')
                                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="durasi_menit" class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Durasi Pengerjaan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="durasi_menit" id="durasi_menit" min="1" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 pr-20 focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-colors shadow-sm" required placeholder="Contoh: 90">
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
                            <button type="submit" class="px-8 py-3 bg-[#5c54d8] hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                                Simpan Jadwal Ujian
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
