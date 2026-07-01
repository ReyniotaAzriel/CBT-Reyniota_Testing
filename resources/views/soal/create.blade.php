<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                <span class="text-blue-600">Tambah</span> Soal Baru
            </h2>
            <a href="{{ route('soal.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Bank Soal
            </a>
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
                        <h3 class="text-xl font-extrabold text-gray-900">Formulir Pembuatan Soal</h3>
                        <p class="text-gray-500 mt-1 text-sm">Lengkapi kolom di bawah ini untuk menambahkan pertanyaan baru ke dalam jadwal ujian.</p>
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

    <script>
        function toggleTipeSoal(val) {
            const pgContainer = document.getElementById('pg-container');
            const radioKunci = document.querySelectorAll('input[name="kunci_benar"]');

            if(val === 'essay') {
                pgContainer.style.display = 'none';
                // Menghilangkan atribut required agar saat diklik submit form tetap jalan untuk tipe essay
                radioKunci.forEach(radio => radio.removeAttribute('required'));
            } else {
                pgContainer.style.display = 'block';
                // Mengembalikan required ke radio pertama
                if(radioKunci.length > 0) {
                    radioKunci[0].setAttribute('required', 'required');
                }
            }
        }
    </script>
</x-app-layout>
