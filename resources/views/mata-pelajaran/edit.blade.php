<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Mata Pelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('mata-pelajaran.update', $mataPelajaran->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <label for="nama_pelajaran" class="block text-gray-700 text-sm font-bold mb-2">Nama Pelajaran:</label>

                            <input type="text" name="nama_pelajaran" id="nama_pelajaran" value="{{ old('nama_pelajaran', $mataPelajaran->nama_pelajaran) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>

                            @error('nama_pelajaran')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                                Perbarui Data
                            </button>
                            <a href="{{ route('mata-pelajaran.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                                Batal & Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
