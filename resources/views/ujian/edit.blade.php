<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Ujian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('ujian.update', $ujian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="mata_pelajaran_id" class="block text-gray-700 text-sm font-bold mb-2">Mata Pelajaran:</label>
                            <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @foreach($mataPelajaran as $mapel)
                                    <option value="{{ $mapel->id }}" {{ $ujian->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama_pelajaran }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mata_pelajaran_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="judul_ujian" class="block text-gray-700 text-sm font-bold mb-2">Judul Ujian:</label>
                            <input type="text" name="judul_ujian" id="judul_ujian" value="{{ old('judul_ujian', $ujian->judul_ujian) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('judul_ujian') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_ujian" class="block text-gray-700 text-sm font-bold mb-2">Tanggal & Waktu Mulai:</label>
                            <input type="datetime-local" name="tanggal_ujian" id="tanggal_ujian" value="{{ old('tanggal_ujian', \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('Y-m-d\TH:i')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('tanggal_ujian') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="durasi_menit" class="block text-gray-700 text-sm font-bold mb-2">Durasi (Menit):</label>
                            <input type="number" name="durasi_menit" id="durasi_menit" value="{{ old('durasi_menit', $ujian->durasi_menit) }}" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('durasi_menit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Perbarui Jadwal
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
