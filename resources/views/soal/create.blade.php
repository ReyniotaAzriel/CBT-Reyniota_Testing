<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Tambah <span class="text-[#5c54d8]">Soal Baru</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f4f7fe] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">

                <!-- Header Kartu & Area Tombol Aksi -->
                <div class="p-8 border-b border-gray-50 bg-gradient-to-r from-indigo-50/50 to-white flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-[#5c54d8] mr-4 shadow-sm shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Formulir Pembuatan Soal</h3>
                            <p class="text-gray-500 mt-1 text-sm font-medium">Lengkapi form manual atau gunakan fitur import Excel.</p>
                        </div>
                    </div>

                    <!-- Tombol Aksi Dipindah ke Sini -->
                    <div class="flex flex-wrap items-center gap-3" x-data>
                        <a href="{{ route('soal.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-gray-600 hover:text-[#5c54d8] hover:bg-indigo-50 hover:border-indigo-200 transition-colors shadow-sm text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali
                        </a>
                        <a href="{{ asset('templates/template_soal.xlsx') }}" download class="inline-flex items-center px-4 py-2.5 bg-gray-800 border border-transparent rounded-xl font-bold text-white hover:bg-gray-700 transition-colors shadow-sm text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Format
                        </a>
                        <button type="button" @click="$dispatch('open-modal', 'modal-import-global')" class="inline-flex items-center px-4 py-2.5 bg-emerald-500 border border-transparent rounded-xl font-bold text-white hover:bg-emerald-600 transition-colors shadow-sm text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Import Excel
                        </button>
                    </div>
                </div>

                <!-- Isi Form Manual berbasis Alpine JS -->
                <div class="p-8 md:p-10">
                    <form action="{{ route('soal.store') }}" method="POST" x-data="{ tipe_soal: 'pg' }">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

                            <!-- Custom Dropdown Alpine: Tujuan Ujian -->
                            <div class="relative z-20">
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Tujuan Ujian <span class="text-red-500">*</span></label>
                                <div class="relative" x-data="{ open: false, selected: '', selectedLabel: '-- Pilih Jadwal Ujian --' }">
                                    <input type="hidden" name="ujian_id" x-model="selected" required>

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
                                            @foreach($ujian as $item)
                                                <li @click="selected = '{{ $item->id }}'; selectedLabel = '{{ addslashes($item->judul_ujian) }}'; open = false"
                                                    class="px-5 py-3 hover:bg-indigo-50 cursor-pointer transition-colors flex items-center justify-between"
                                                    :class="selected == '{{ $item->id }}' ? 'bg-indigo-50 text-[#5c54d8]' : 'text-gray-600'">
                                                    <span class="font-semibold">{{ $item->judul_ujian }}</span>
                                                    <svg x-show="selected == '{{ $item->id }}'" class="w-5 h-5 text-[#5c54d8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Dropdown Alpine: Tipe Soal -->
                            <div class="relative z-10">
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Tipe Soal <span class="text-red-500">*</span></label>
                                <div class="relative" x-data="{ open: false, options: { 'pg': 'Pilihan Ganda (PG)', 'essay': 'Essay' } }">
                                    <input type="hidden" name="tipe_soal" x-model="tipe_soal" required>

                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="flex justify-between items-center w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-all cursor-pointer shadow-sm">
                                        <span x-text="options[tipe_soal]" class="font-semibold text-gray-900"></span>
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
                                            <li @click="tipe_soal = 'pg'; open = false"
                                                class="px-5 py-3 hover:bg-indigo-50 cursor-pointer transition-colors flex items-center justify-between"
                                                :class="tipe_soal == 'pg' ? 'bg-indigo-50 text-[#5c54d8]' : 'text-gray-600'">
                                                <span class="font-semibold">Pilihan Ganda (PG)</span>
                                                <svg x-show="tipe_soal == 'pg'" class="w-5 h-5 text-[#5c54d8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </li>
                                            <li @click="tipe_soal = 'essay'; open = false"
                                                class="px-5 py-3 hover:bg-indigo-50 cursor-pointer transition-colors flex items-center justify-between"
                                                :class="tipe_soal == 'essay' ? 'bg-indigo-50 text-[#5c54d8]' : 'text-gray-600'">
                                                <span class="font-semibold">Essay</span>
                                                <svg x-show="tipe_soal == 'essay'" class="w-5 h-5 text-[#5c54d8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Teks Pertanyaan -->
                        <div class="mb-8 border-t border-gray-50 pt-8">
                            <label for="teks_soal" class="block text-gray-500 text-xs font-bold uppercase tracking-widest mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#5c54d8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Teks Pertanyaan <span class="text-red-500 ml-1">*</span>
                            </label>
                            <textarea name="teks_soal" id="teks_soal" rows="5" class="bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-2xl focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] block w-full p-5 transition-colors shadow-sm leading-relaxed" placeholder="Ketikkan pertanyaan soal secara detail di sini..." required></textarea>
                        </div>

                        <!-- Pilihan Jawaban Khusus PG (Tampil/Hilang otomatis pakai Alpine) -->
                        <div x-show="tipe_soal === 'pg'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="mb-8 border-t border-gray-50 pt-8" style="display: none;">
                            <div class="flex items-center mb-6">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                <h4 class="font-bold text-gray-500 uppercase tracking-widest text-xs">Pilihan Jawaban (Khusus PG)</h4>
                            </div>

                            <div class="space-y-4 relative z-0">
                                @php $abjad = ['A', 'B', 'C', 'D', 'E']; @endphp
                                @foreach($abjad as $index => $huruf)
                                    <div class="flex flex-col sm:flex-row sm:items-center bg-white border border-gray-200 p-3 rounded-2xl hover:border-indigo-300 transition-colors shadow-sm gap-3 relative overflow-hidden group">

                                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-[#5c54d8] font-black text-xl shrink-0 group-hover:bg-[#5c54d8] group-hover:text-white transition-colors">
                                            {{ $huruf }}
                                        </div>

                                        <input type="text" name="pilihan[{{ $index }}]" class="bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] block w-full p-3.5 transition-colors" placeholder="Masukkan teks jawaban {{ $huruf }}...">

                                        <label class="flex items-center shrink-0 cursor-pointer bg-gray-50 hover:bg-green-50 px-5 py-3.5 rounded-xl border border-gray-200 hover:border-green-300 transition-colors group-hover:bg-green-50">
                                            <!-- x-bind:required agar tidak ngebug html5 validation pas form hidden -->
                                            <input type="radio" name="kunci_benar" value="{{ $index }}" class="w-5 h-5 text-green-500 focus:ring-green-500 border-gray-300 cursor-pointer" x-bind:required="tipe_soal === 'pg'">
                                            <span class="ml-3 text-sm font-bold text-gray-700">Jadikan Kunci</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-500 mt-5 flex items-center bg-yellow-50 text-yellow-800 px-4 py-3 rounded-lg border border-yellow-200 w-full">
                                <svg class="w-5 h-5 mr-2 shrink-0 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium">Pilih salah satu lingkaran <b>"Jadikan Kunci"</b> untuk menentukan jawaban yang benar.</span>
                            </p>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex items-center justify-end mt-10 pt-8 border-t border-gray-50">
                            <button type="submit" class="inline-flex items-center justify-center bg-[#5c54d8] hover:bg-indigo-700 text-white text-lg font-black tracking-wide py-4 px-10 rounded-2xl shadow-xl shadow-indigo-200 transition-all transform hover:-translate-y-1 hover:scale-105 active:scale-95">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                SIMPAN SOAL
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Import Excel -->
    <div x-data="{ showModal: false }"
         x-on:open-modal.window="if ($event.detail === 'modal-import-global') showModal = true"
         x-on:close-modal.window="showModal = false"
         x-on:keydown.escape.window="showModal = false"
         x-show="showModal"
         class="fixed inset-0 z-[100] flex items-center justify-center px-4 sm:px-6"
         style="display: none;"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div x-show="showModal"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity cursor-pointer"
             @click="showModal = false" aria-hidden="true"></div>

        <div x-show="showModal"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-3xl text-left overflow-visible shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full z-10">

            <form action="{{ route('soal.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-6 pt-8 pb-6 sm:px-8 sm:pb-8">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-emerald-100 sm:mx-0 sm:h-12 sm:w-12 shadow-sm">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:ml-5 sm:text-left w-full">
                            <h3 class="text-xl font-black text-gray-900" id="modal-title">Import Soal dari Excel</h3>
                            <p class="text-sm text-gray-500 mt-1 mb-6 font-medium">Pilih ujian tujuan dan unggah file excel sesuai template.</p>

                            <div class="mb-6 text-left relative z-20">
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">1. Pilih Tujuan Ujian <span class="text-red-500">*</span></label>
                                <!-- Custom Dropdown Alpine di dalam Modal -->
                                <div class="relative" x-data="{ openDropdown: false, selected: '', selectedLabel: '-- Silakan Pilih Ujian --' }">
                                    <input type="hidden" name="ujian_id" x-model="selected" required>
                                    <button type="button" @click="openDropdown = !openDropdown" @click.outside="openDropdown = false" class="flex justify-between items-center w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-all cursor-pointer shadow-sm">
                                        <span x-text="selectedLabel" :class="selected === '' ? 'text-gray-400' : 'font-semibold text-gray-900'"></span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="openDropdown" style="display: none;" x-transition class="absolute z-[100] w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden max-h-48 overflow-y-auto custom-scrollbar">
                                        <ul class="py-1">
                                            @foreach($ujian as $item)
                                                <li @click="selected = '{{ $item->id }}'; selectedLabel = '{{ addslashes($item->judul_ujian) }}'; openDropdown = false" class="px-5 py-3 hover:bg-indigo-50 cursor-pointer transition-colors flex items-center justify-between" :class="selected == '{{ $item->id }}' ? 'bg-indigo-50 text-[#5c54d8]' : 'text-gray-600'">
                                                    <span class="font-semibold">{{ $item->judul_ujian }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="text-left relative z-10">
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">2. Upload File Excel <span class="text-red-500">*</span></label>
                                <input type="file" name="file" accept=".xlsx, .xls" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-[#5c54d8] transition-colors text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-100 file:text-[#5c54d8] hover:file:bg-indigo-200 cursor-pointer shadow-sm" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-5 sm:px-8 sm:flex sm:flex-row-reverse border-t border-gray-100 rounded-b-3xl">
                    <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl shadow-lg shadow-emerald-200 px-6 py-3 bg-emerald-500 text-base font-bold text-white hover:bg-emerald-600 focus:outline-none transition-colors sm:ml-3 sm:w-auto sm:text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Mulai Import
                    </button>
                    <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-600 hover:bg-gray-50 focus:outline-none transition-colors sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(156, 163, 175, 0.5); border-radius: 20px; }
    </style>
</x-app-layout>
