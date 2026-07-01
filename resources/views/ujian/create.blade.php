<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Ujian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('ujian.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="mata_pelajaran_id" class="block text-gray-700 text-sm font-bold mb-2">Mata Pelajaran:</label>
                            <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($mataPelajaran as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama_pelajaran }}</option>
                                @endforeach
                            </select>
                            @error('mata_pelajaran_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="judul_ujian" class="block text-gray-700 text-sm font-bold mb-2">Judul Ujian:</label>
                            <input type="text" name="judul_ujian" id="judul_ujian" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: Ujian Tengah Semester Ganjil">
                            @error('judul_ujian') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_ujian" class="block text-gray-700 text-sm font-bold mb-2">Tanggal & Waktu Mulai:</label>
                            <input type="datetime-local" name="tanggal_ujian" id="tanggal_ujian" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('tanggal_ujian') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="durasi_menit" class="block text-gray-700 text-sm font-bold mb-2">Durasi (Menit):</label>
                            <input type="number" name="durasi_menit" id="durasi_menit" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: 90">
                            @error('durasi_menit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Jadwal
                            </button>
                            <a href="{{ route('ujian.index') }}" class="font-bold text-sm text-gray-500 hover:text-gray-800">
                                Batal & Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
