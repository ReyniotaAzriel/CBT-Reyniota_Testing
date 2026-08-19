<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Data Master <span class="text-[#5c54d8]">Mata Pelajaran</span>
        </h2>
    </x-slot>

    <!-- Wrapper x-data untuk kontrol Modal Hapus dari Alpine -->
    <div x-data="{ deleteModalOpen: false, deleteFormAction: '' }" class="py-12 bg-[#f4f7fe] min-h-screen relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="p-8 border-b border-gray-50 bg-gradient-to-r from-indigo-50/50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Daftar Mata Pelajaran</h3>
                        <p class="text-gray-500 mt-1 text-sm">Kelola seluruh mata pelajaran yang tersedia di sekolah.</p>
                    </div>
                    <a href="{{ route('mata-pelajaran.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-[#5c54d8] hover:bg-indigo-700 text-white text-sm font-black rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1 hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Mapel
                    </a>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-8 py-5 font-bold border-b border-gray-100 text-center w-20">No</th>
                                <th class="px-8 py-5 font-bold border-b border-gray-100">Nama Pelajaran</th>
                                <th class="px-8 py-5 font-bold border-b border-gray-100 text-center w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($mataPelajaran as $index => $mapel)
                                <tr class="hover:bg-[#f4f7fe]/50 transition duration-150">
                                    <td class="px-8 py-6 text-center text-gray-500 font-bold">{{ $index + 1 }}</td>
                                    <td class="px-8 py-6 text-gray-900 font-semibold text-lg">{{ $mapel->nama_pelajaran }}</td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('mata-pelajaran.edit', $mapel->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 text-xs font-black rounded-lg transition-colors border border-yellow-200/50">
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus memicu Modal Alpine -->
                                            <button type="button"
                                                @click="deleteModalOpen = true; deleteFormAction = '{{ route('mata-pelajaran.destroy', $mapel->id) }}'"
                                                class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-black rounded-lg transition-colors border border-red-200/50">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-16 text-center text-gray-400 font-medium">
                                        Belum ada data mata pelajaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL KONFIRMASI HAPUS (TAILWIND) -->
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4 sm:px-6">

            <!-- Backdrop Hitam Transparan -->
            <div x-show="deleteModalOpen"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm cursor-pointer"
                 @click="deleteModalOpen = false"></div>

            <!-- Konten Modal -->
            <div x-show="deleteModalOpen"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 md:p-8 overflow-hidden z-10 text-center">

                <!-- Ikon Peringatan -->
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>

                <h3 class="text-2xl font-black text-gray-900 mb-2">Yakin Ingin Dihapus?</h3>
                <p class="text-gray-500 font-medium mb-8">Data mata pelajaran ini akan dihapus secara permanen dari sistem dan tidak dapat dikembalikan.</p>

                <!-- Form Hapus & Tombol Batal -->
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <button type="button" @click="deleteModalOpen = false" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors w-full sm:w-auto focus:outline-none">
                        Batal
                    </button>
                    <!-- Form ini action-nya bakal dinamis diisi sama Alpine.js -->
                    <form :action="deleteFormAction" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-transform transform hover:-translate-y-0.5 focus:outline-none">
                            Ya, Hapus!
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
