<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Manajemen <span class="text-blue-600">Jadwal Ujian</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">

                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white flex items-center gap-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Tambah Jadwal Baru</h3>
                        <p class="text-gray-500 text-sm mt-1">Lengkapi formulir di bawah ini untuk mengatur waktu dan mata pelajaran yang diujikan.</p>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('ujian.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="mata_pelajaran_id" class="block text-sm font-bold text-gray-700 mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 cursor-pointer appearance-none" required>
                                    <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                    @foreach($mataPelajaran as $mapel)
                                        <option value="{{ $mapel->id }}">{{ $mapel->nama_pelajaran }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('mata_pelajaran_id')
                                <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="judul_ujian" class="block text-sm font-bold text-gray-700 mb-2">Judul Ujian <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_ujian" id="judul_ujian" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200" required placeholder="Contoh: Ujian Tengah Semester Ganjil">
                            @error('judul_ujian')
                                <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tanggal_ujian" class="block text-sm font-bold text-gray-700 mb-2">Tanggal & Waktu Mulai <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="tanggal_ujian" id="tanggal_ujian" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200" required>
                                @error('tanggal_ujian')
                                    <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="durasi_menit" class="block text-sm font-bold text-gray-700 mb-2">Durasi Pengerjaan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="durasi_menit" id="durasi_menit" min="1" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 pr-20 transition-colors duration-200" required placeholder="Contoh: 90">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <span class="text-gray-500 font-medium text-sm">Menit</span>
                                    </div>
                                </div>
                                @error('durasi_menit')
                                    <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <hr class="border-gray-100 my-6">

                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-6">
                            <a href="{{ route('ujian.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3.5 bg-white border border-gray-300 text-sm font-bold text-gray-700 rounded-xl hover:bg-gray-50 hover:text-blue-600 transition-colors duration-200 shadow-sm">
                                Batal & Kembali
                            </a>
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3.5 bg-blue-600 text-white text-sm font-black rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transform transition-all hover:-translate-y-0.5 active:translate-y-0">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Jadwal Ujian
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
