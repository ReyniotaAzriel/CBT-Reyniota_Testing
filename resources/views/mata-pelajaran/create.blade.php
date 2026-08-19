<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Tambah <span class="text-[#5c54d8]">Mata Pelajaran</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f4f7fe] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header Kartu -->
                <div class="p-8 border-b border-gray-50 bg-gradient-to-r from-indigo-50/50 to-white">
                    <h3 class="text-xl font-black text-gray-900">Form Tambah Pelajaran</h3>
                    <p class="text-sm text-gray-500 mt-1">Masukkan nama mata pelajaran baru ke dalam sistem.</p>
                </div>

                <!-- Isi Form -->
                <div class="p-8 md:p-10">
                    <form action="{{ route('mata-pelajaran.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="nama_pelajaran" class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Nama Pelajaran</label>
                            <input type="text" name="nama_pelajaran" id="nama_pelajaran" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-colors shadow-sm" required placeholder="Contoh: Matematika">

                            @error('nama_pelajaran')
                                <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex justify-end mt-8 border-t border-gray-50 pt-6">
                            <a href="{{ route('mata-pelajaran.index') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl mr-4 hover:bg-gray-50 transition-colors shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-[#5c54d8] hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
