<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                <span class="text-blue-600">Tambah</span> Soal Baru
            </h2>

            <div class="flex flex-wrap items-center gap-3" x-data>

                <a href="{{ asset('templates/template_soal.xlsx') }}" download class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-white hover:bg-gray-700 transition ease-in-out duration-150 shadow-sm text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh Format
                </a>

                <button type="button" @click="$dispatch('open-modal', 'modal-import-global')" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-white hover:bg-emerald-700 transition ease-in-out duration-150 shadow-sm text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Import Excel
                </button>

                <a href="{{ route('soal.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition ease-in-out duration-150 shadow-sm text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden mb-8">

                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white flex items-center">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white mr-4 shadow-lg shadow-blue-200 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Formulir Pembuatan Soal Manual</h3>
                        <p class="text-gray-500 mt-1 text-sm">Lengkapi kolom di bawah ini untuk menambahkan satu pertanyaan baru secara manual.</p>
                    </div>
                </div>

                <div class="p-8 md:p-10">
                    <form action="{{ route('soal.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label for="ujian_id" class="block text-gray-500 text-sm font-bold uppercase tracking-widest mb-2">Tujuan Ujian</label>
                                <select name="ujian_id" id="ujian_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4 transition-colors shadow-sm" required>
                                    <option value="">-- Pilih Jadwal Ujian --</option>
                                    @foreach($ujian as $item)
                                        <option value="{{ $item->id }}" class="font-medium">{{ $item->judul_ujian }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-500 text-sm font-bold uppercase tracking-widest mb-2">Tipe Soal</label>
                                <select name="tipe_soal" id="tipe_soal" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4 transition-colors shadow-sm" onchange="toggleTipeSoal(this.value)" required>
                                    <option value="pg" class="font-medium">Pilihan Ganda (PG)</option>
                                    <option value="essay" class="font-medium">Essay</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-8 border-t border-gray-100 pt-8">
                            <label for="teks_soal" class="block text-gray-700 text-sm font-bold uppercase tracking-widest mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Teks Pertanyaan
                            </label>
                            <textarea name="teks_soal" id="teks_soal" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-2xl focus:ring-blue-500 focus:border-blue-500 block w-full p-5 transition-colors shadow-sm leading-relaxed" placeholder="Ketikkan pertanyaan soal secara detail di sini..." required></textarea>
                        </div>

                        <div id="pg-container" class="mb-8 border-t border-gray-100 pt-8">
                            <div class="flex items-center mb-6">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                <h4 class="font-bold text-gray-700 uppercase tracking-widest text-sm">Pilihan Jawaban (Khusus PG)</h4>
                            </div>

                            <div class="space-y-4">
                                @php $abjad = ['A', 'B', 'C', 'D', 'E']; @endphp
                                @foreach($abjad as $index => $huruf)
                                    <div class="flex flex-col sm:flex-row sm:items-center bg-white border-2 border-gray-100 p-3 rounded-2xl hover:border-blue-300 transition-colors shadow-sm gap-3 relative overflow-hidden group">

                                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 text-blue-700 font-black text-xl shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                            {{ $huruf }}
                                        </div>

                                        <input type="text" name="pilihan[{{ $index }}]" class="bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 transition-colors" placeholder="Masukkan teks jawaban {{ $huruf }}...">

                                        <label class="flex items-center shrink-0 cursor-pointer bg-gray-50 hover:bg-green-50 px-5 py-3.5 rounded-xl border border-gray-200 hover:border-green-300 transition-colors group-hover:bg-green-50">
                                            <input type="radio" name="kunci_benar" value="{{ $index }}" class="w-5 h-5 text-green-600 focus:ring-green-500 border-gray-300 cursor-pointer" {{ $index == 0 ? 'required' : '' }}>
                                            <span class="ml-3 text-sm font-bold text-gray-700">Jadikan Kunci</span>
                                        </label>

                                    </div>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-500 mt-5 flex items-center bg-yellow-50 text-yellow-800 px-4 py-3 rounded-lg border border-yellow-200 inline-block w-full">
                                <svg class="w-5 h-5 mr-2 shrink-0 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium">Pilih salah satu lingkaran <b>"Jadikan Kunci"</b> untuk menentukan jawaban yang benar.</span>
                            </p>
                        </div>

                        <div class="flex items-center justify-end mt-10 pt-8 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-lg font-black tracking-wide py-4 px-10 rounded-2xl shadow-xl shadow-blue-200 transition-all transform hover:-translate-y-1 hover:scale-105 active:scale-95">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                SIMPAN SOAL
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div x-data="{ showModal: false }"
         x-on:open-modal.window="if ($event.detail === 'modal-import-global') showModal = true"
         x-on:close-modal.window="showModal = false"
         x-on:keydown.escape.window="showModal = false"
         x-show="showModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
                 @click="showModal = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">

                <form action="{{ route('soal.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Import Soal dari Excel</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">Pilih ujian tujuan dan unggah file excel sesuai dengan format template yang disediakan.</p>

                                    <div class="mb-4 text-left">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">1. Pilih Tujuan Ujian <span class="text-red-500">*</span></label>
                                        <select name="ujian_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            <option value="">-- Silakan Pilih Ujian --</option>
                                            @foreach($ujian as $item)
                                                <option value="{{ $item->id }}">{{ $item->judul_ujian }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="text-left">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">2. Upload File Excel <span class="text-red-500">*</span></label>
                                        <input type="file" name="file" accept=".xlsx, .xls" class="w-full border border-gray-300 p-2 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Mulai Import
                        </button>
                        <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleTipeSoal(val) {
            const pgContainer = document.getElementById('pg-container');
            const radioKunci = document.querySelectorAll('input[name="kunci_benar"]');

            if(val === 'essay') {
                pgContainer.style.display = 'none';
                radioKunci.forEach(radio => radio.removeAttribute('required'));
            } else {
                pgContainer.style.display = 'block';
                if(radioKunci.length > 0) {
                    radioKunci[0].setAttribute('required', 'required');
                }
            }
        }
    </script>
</x-app-layout>
