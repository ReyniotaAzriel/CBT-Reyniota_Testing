<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Detail <span class="text-[#5c54d8]">Soal Ujian</span>
        </h2>
    </x-slot>

    <!-- Wrapper x-data untuk kontrol Modal Delete & Modal Import dari Alpine -->
    <div x-data="{ deleteModalOpen: false, deleteFormAction: '', importModalOpen: false }" class="py-12 bg-[#f4f7fe] min-h-screen relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">

                <!-- Premium Header & Area Tombol Aksi -->
                <div class="p-8 border-b border-gray-50 bg-gradient-to-r from-indigo-50/50 to-white flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-[#5c54d8] mr-4 shadow-sm shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Mata Ujian</p>
                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 bg-indigo-50 text-[#5c54d8] text-[10px] font-black rounded-md border border-indigo-100 uppercase">
                                    Total: {{ $soal->count() }} Soal
                                </span>
                            </div>
                            <h4 class="text-xl font-black text-gray-900">{{ $ujian->judul_ujian }}</h4>
                        </div>
                    </div>

                    <!-- Kumpulan Tombol Aksi -->
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('soal.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-gray-600 hover:text-[#5c54d8] hover:bg-indigo-50 hover:border-indigo-200 transition-colors shadow-sm text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali
                        </a>
                        <a href="{{ asset('templates/template_soal.xlsx') }}" download class="inline-flex items-center px-4 py-2.5 bg-gray-800 border border-transparent rounded-xl font-bold text-white hover:bg-gray-700 transition-colors shadow-sm text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Format
                        </a>
                        <button type="button" @click="importModalOpen = true" class="inline-flex items-center px-4 py-2.5 bg-emerald-500 border border-transparent rounded-xl font-bold text-white hover:bg-emerald-600 transition-colors shadow-sm text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Import Excel
                        </button>
                        <a href="{{ route('soal.create') }}" class="inline-flex items-center px-4 py-2.5 bg-[#5c54d8] border border-transparent rounded-xl font-bold text-white hover:bg-indigo-700 transition-colors shadow-sm text-xs uppercase tracking-wider transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Soal
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 text-gray-500 text-[10px] font-black uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-5 text-center w-16">No</th>
                                <th class="px-6 py-5">Teks Soal</th>
                                <th class="px-6 py-5 text-center">Tipe Soal</th>
                                <th class="px-6 py-5 text-center">Opsi / Kunci</th>
                                <th class="px-6 py-5 text-center w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($soal as $index => $item)
                                <tr class="hover:bg-[#f4f7fe]/50 transition duration-150">
                                    <td class="px-6 py-5 text-center text-gray-500 font-bold">{{ $index + 1 }}</td>
                                    <td class="px-6 py-5 text-gray-800 text-sm font-medium">
                                        {{ Str::limit($item->teks_soal, 80) }}
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($item->tipe_soal == 'essay')
                                            <span class="inline-block px-3 py-1.5 bg-purple-50 border border-purple-100 text-purple-600 text-[10px] font-black rounded-lg uppercase tracking-wider">
                                                Essay
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1.5 bg-indigo-50 border border-indigo-100 text-[#5c54d8] text-[10px] font-black rounded-lg uppercase tracking-wider">
                                                PG
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center text-gray-600 text-sm font-bold">
                                        @if ($item->tipe_soal == 'essay')
                                            <span class="text-gray-300">-</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-50 border border-gray-200 text-gray-700 rounded-lg">
                                                {{ $item->jawabans->count() }} Pilihan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('soal.edit', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 text-xs font-black rounded-lg transition-colors border border-yellow-200/50">
                                                Edit
                                            </a>
                                            <!-- Tombol Hapus memicu Modal Alpine -->
                                            <button type="button" @click="deleteModalOpen = true; deleteFormAction = '{{ route('soal.destroy', $item->id) }}'" class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-black rounded-lg transition-colors border border-red-200/50">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <p class="font-bold">Ujian ini belum memiliki soal.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL KONFIRMASI HAPUS (TAILWIND/ALPINE) -->
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4 sm:px-6">
            <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm cursor-pointer" @click="deleteModalOpen = false"></div>

            <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 md:p-8 overflow-hidden z-10 text-center">
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Yakin Ingin Dihapus?</h3>
                <p class="text-gray-500 font-medium mb-8">Data soal dan pilihan jawabannya akan terhapus secara permanen.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <button type="button" @click="deleteModalOpen = false" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors w-full sm:w-auto focus:outline-none">Batal</button>
                    <form :action="deleteFormAction" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-transform transform hover:-translate-y-0.5 focus:outline-none">Ya, Hapus!</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL IMPORT EXCEL (TAILWIND/ALPINE) -->
        <div x-show="importModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4 sm:px-6">
            <div x-show="importModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm cursor-pointer" @click="importModalOpen = false"></div>

            <div x-show="importModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden z-10 text-left">

                <form method="post" action="{{ route('soal.import', $ujian->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 pt-8 pb-6 sm:px-8 sm:pb-8">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-emerald-100 sm:mx-0 sm:h-12 sm:w-12 shadow-sm">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <div class="mt-4 text-center sm:mt-0 sm:ml-5 sm:text-left w-full">
                                <h3 class="text-xl font-black text-gray-900">Import Soal via Excel</h3>
                                <p class="text-sm text-gray-500 mt-1 mb-6 font-medium">Unggah file excel untuk menambahkan soal sekaligus.</p>

                                <div class="mb-4 text-xs font-medium text-gray-600 space-y-2 bg-gray-50 p-4 rounded-xl border border-gray-200 text-left">
                                    <p>1. Buat file .xlsx dengan susunan kolom persis di baris pertama:</p>
                                    <div class="bg-white p-2 rounded-lg font-mono text-[10px] overflow-x-auto border border-gray-200 text-gray-500 whitespace-nowrap">
                                        teks_soal | tipe_soal | opsi_a | opsi_b | opsi_c | opsi_d | opsi_e | kunci_jawaban
                                    </div>
                                    <p>2. Kolom <span class="font-bold text-gray-800">tipe_soal</span> diisi dengan "pg" atau "essay".</p>
                                    <p>3. Kosongkan kolom opsi dan kunci untuk soal "essay".</p>
                                </div>

                                <div class="mt-4 text-left relative z-10 border-2 border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" class="w-full focus:outline-none text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 cursor-pointer" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-5 sm:px-8 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl shadow-lg shadow-emerald-200 px-6 py-3 bg-emerald-500 text-base font-bold text-white hover:bg-emerald-600 focus:outline-none transition-colors sm:ml-3 sm:w-auto sm:text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Mulai Import
                        </button>
                        <button type="button" @click="importModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-600 hover:bg-gray-50 focus:outline-none transition-colors sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(156, 163, 175, 0.5); border-radius: 20px; }
    </style>
</x-app-layout>
