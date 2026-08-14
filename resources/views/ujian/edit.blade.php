<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Manajemen <span class="text-blue-600">Jadwal Ujian</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">

                <!-- Premium Header Edit -->
                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-white flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Edit Jadwal Ujian</h3>
                        <p class="text-gray-500 text-sm mt-1">Perbarui data mata pelajaran, peserta, dan waktu ujian ini.</p>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('ujian.update', $ujian->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="mata_pelajaran_id" class="block text-sm font-bold text-gray-700 mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 cursor-pointer appearance-none" required>
                                    @foreach($mataPelajaran as $mapel)
                                        <option value="{{ $mapel->id }}" {{ $ujian->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('mata_pelajaran_id') <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="judul_ujian" class="block text-sm font-bold text-gray-700 mb-2">Judul Ujian <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_ujian" id="judul_ujian" value="{{ old('judul_ujian', $ujian->judul_ujian) }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200" required>
                            @error('judul_ujian') <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- FILTER KELAS & JURUSAN (EDIT) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 bg-blue-50/50 rounded-2xl border border-blue-100">
                            <div>
                                <label for="kelas" class="block text-sm font-bold text-gray-700 mb-2">Target Kelas <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="kelas" id="kelas" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 cursor-pointer appearance-none" required>
                                        <option value="Semua Kelas" {{ $ujian->kelas == 'Semua Kelas' ? 'selected' : '' }}>Semua Kelas</option>
                                        <option value="X" {{ $ujian->kelas == 'X' ? 'selected' : '' }}>Kelas X</option>
                                        <option value="XI" {{ $ujian->kelas == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                                        <option value="XII" {{ $ujian->kelas == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="jurusan" class="block text-sm font-bold text-gray-700 mb-2">Target Jurusan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="jurusan" id="jurusan" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 cursor-pointer appearance-none" required>
                                        <option value="Semua Jurusan" {{ $ujian->jurusan == 'Semua Jurusan' ? 'selected' : '' }}>Semua Jurusan</option>
                                        <option value="RPL" {{ $ujian->jurusan == 'RPL' ? 'selected' : '' }}>RPL (Rekayasa Perangkat Lunak)</option>
                                        <option value="TKJ" {{ $ujian->jurusan == 'TKJ' ? 'selected' : '' }}>TKJ (Teknik Komputer Jaringan)</option>
                                        <option value="Akuntansi" {{ $ujian->jurusan == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                                        <option value="Perkantoran" {{ $ujian->jurusan == 'Perkantoran' ? 'selected' : '' }}>Perkantoran</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tanggal_ujian" class="block text-sm font-bold text-gray-700 mb-2">Tanggal & Waktu Mulai <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="tanggal_ujian" id="tanggal_ujian" value="{{ old('tanggal_ujian', \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('Y-m-d\TH:i')) }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200" required>
                                @error('tanggal_ujian') <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="durasi_menit" class="block text-sm font-bold text-gray-700 mb-2">Durasi Pengerjaan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="durasi_menit" id="durasi_menit" value="{{ old('durasi_menit', $ujian->durasi_menit) }}" min="1" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 pr-20 transition-colors duration-200" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <span class="text-gray-500 font-medium text-sm">Menit</span>
                                    </div>
                                </div>
                                @error('durasi_menit') <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <hr class="border-gray-100 my-6">

                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-6">
                            <a href="{{ route('ujian.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3.5 bg-white border border-gray-300 text-sm font-bold text-gray-700 rounded-xl hover:bg-gray-50 hover:text-blue-600 transition-colors duration-200 shadow-sm">
                                Batal & Kembali
                            </a>
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3.5 bg-yellow-500 text-white text-sm font-black rounded-xl shadow-lg shadow-yellow-200 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 transform transition-all hover:-translate-y-0.5 active:translate-y-0">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Perbarui Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
