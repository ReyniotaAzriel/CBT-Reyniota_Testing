<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Edit <span class="text-[#5c54d8]">Soal Ujian</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f4f7fe] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8 transition-all duration-300 hover:shadow-md">

                <!-- Header Kartu & Area Tombol Aksi -->
                <div class="p-8 border-b border-gray-50 bg-gradient-to-r from-yellow-50/50 to-white flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 mr-4 shadow-sm shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Perbarui Data Soal</h3>
                            <p class="text-gray-500 mt-1 text-sm font-medium">Edit pertanyaan atau ubah kunci jawaban untuk soal ini.</p>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="flex items-center">
                        <a href="{{ route('soal.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 hover:border-yellow-200 transition-colors shadow-sm text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Isi Form -->
                <div class="p-8 md:p-10">

                    <!-- Alert Error Backend (Akan muncul jika Controller menolak data) -->
                    @if ($errors->any())
                        <div class="mb-8 p-5 bg-red-50 border border-red-200 rounded-2xl text-red-600 font-medium text-sm">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span class="font-bold">Gagal menyimpan data! Periksa kembali isian Anda:</span>
                            </div>
                            <ul class="list-disc list-inside ml-7">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('soal.update', $soal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- WAJIB DIKIRIM AGAR VALIDASI BACKEND TIDAK GAGAL SILUMAN -->
                        <input type="hidden" name="tipe_soal" value="{{ $soal->tipe_soal }}">

                        <div class="mb-8 relative z-20">
                            <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Tujuan Ujian <span class="text-red-500">*</span></label>

                            <!-- Custom Dropdown Alpine -->
                            @php
                                $selectedUjianName = $ujian->firstWhere('id', $soal->ujian_id)->judul_ujian ?? '-- Pilih Jadwal Ujian --';
                            @endphp
                            <div class="relative" x-data="{ open: false, selected: '{{ $soal->ujian_id }}', selectedLabel: '{{ addslashes($selectedUjianName) }}' }">

                                <!-- FIXED: HAPUS atribut required pada input hidden di bawah ini -->
                                <input type="hidden" name="ujian_id" x-model="selected">

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
                                        @foreach($ujian as $item)
                                            <li @click="selected = '{{ $item->id }}'; selectedLabel = '{{ addslashes($item->judul_ujian) }}'; open = false"
                                                class="px-5 py-3 hover:bg-yellow-50 cursor-pointer transition-colors flex items-center justify-between"
                                                :class="selected == '{{ $item->id }}' ? 'bg-yellow-50 text-yellow-700' : 'text-gray-600'">
                                                <span class="font-semibold">{{ $item->judul_ujian }} ({{ $item->mataPelajaran->nama_pelajaran }})</span>
                                                <svg x-show="selected == '{{ $item->id }}'" class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Teks Pertanyaan -->
                        <div class="mb-8 border-t border-gray-50 pt-8 relative z-10">
                            <label for="teks_soal" class="block text-gray-500 text-xs font-bold uppercase tracking-widest mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Teks Pertanyaan (Soal) <span class="text-red-500 ml-1">*</span>
                            </label>
                            <textarea name="teks_soal" id="teks_soal" rows="5" class="bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-2xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 block w-full p-5 transition-colors shadow-sm leading-relaxed" required>{{ old('teks_soal', $soal->teks_soal) }}</textarea>
                        </div>

                        <!-- Pilihan Jawaban -->
                        <div class="mb-8 border-t border-gray-50 pt-8">

                            @if($soal->tipe_soal == 'pg')
                                <div class="flex items-center mb-6">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    <h4 class="font-bold text-gray-500 uppercase tracking-widest text-xs">Pilihan Jawaban (Khusus PG)</h4>
                                </div>

                                <div class="space-y-4">
                                    @php $abjad = ['A', 'B', 'C', 'D', 'E']; @endphp
                                    @foreach($soal->jawabans as $index => $jawaban)
                                        <div class="flex flex-col sm:flex-row sm:items-center bg-white border border-gray-200 p-3 rounded-2xl hover:border-yellow-300 transition-colors shadow-sm gap-3 relative overflow-hidden group">

                                            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-yellow-50 text-yellow-700 font-black text-xl shrink-0 group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                                                {{ $abjad[$index] ?? '-' }}
                                            </div>

                                            <input type="text" name="pilihan[{{ $index }}]" value="{{ old('pilihan.'.$index, $jawaban->teks_jawaban) }}" class="bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3.5 transition-colors" required>

                                            <label class="flex items-center shrink-0 cursor-pointer bg-gray-50 hover:bg-green-50 px-5 py-3.5 rounded-xl border border-gray-200 hover:border-green-300 transition-colors group-hover:bg-green-50">
                                                <!-- FIXED: Hilangkan atribut required dari radio agar tidak nge-bug -->
                                                <input type="radio" name="kunci_benar" value="{{ $index }}" {{ $jawaban->is_benar ? 'checked' : '' }} class="w-5 h-5 text-green-500 focus:ring-green-500 border-gray-300 cursor-pointer">
                                                <span class="ml-3 text-sm font-bold text-gray-700">Kunci Benar</span>
                                            </label>

                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-purple-50 p-6 rounded-2xl border border-purple-100 flex items-center">
                                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mr-4 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-purple-900 text-lg">Soal Tipe Essay</h4>
                                        <p class="text-purple-700 text-sm font-medium mt-1">Soal ini adalah essay, sehingga tidak memerlukan daftar pilihan ganda maupun kunci jawaban.</p>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex items-center justify-end mt-10 pt-8 border-t border-gray-50">
                            <button type="submit" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white text-lg font-black tracking-wide py-4 px-10 rounded-2xl shadow-xl shadow-yellow-200 transition-all transform hover:-translate-y-1 hover:scale-105 active:scale-95">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                PERBARUI SOAL
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
