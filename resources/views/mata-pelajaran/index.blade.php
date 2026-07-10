<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Data Master <span class="text-blue-600">Mata Pelajaran</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">

                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Daftar Mata Pelajaran</h3>
                        <p class="text-gray-500 mt-1 text-sm">Kelola seluruh mata pelajaran yang tersedia di sekolah.</p>
                    </div>
                    <a href="{{ route('mata-pelajaran.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl shadow-xl shadow-blue-200 transition-all transform hover:-translate-y-1 hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Mapel
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-8 py-5 font-bold border-b border-gray-100 text-center w-20">No</th>
                                <th class="px-8 py-5 font-bold border-b border-gray-100">Nama Pelajaran</th>
                                <th class="px-8 py-5 font-bold border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($mataPelajaran as $index => $mapel)
                                <tr class="hover:bg-blue-50/30 transition duration-150">
                                    <td class="px-8 py-6 text-center text-gray-500 font-bold">{{ $index + 1 }}</td>
                                    <td class="px-8 py-6 text-gray-900 font-semibold text-lg">{{ $mapel->nama_pelajaran }}</td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('mata-pelajaran.edit', $mapel->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs font-black rounded-lg transition-colors">
                                                Edit
                                            </a>

                                            <form action="{{ route('mata-pelajaran.destroy', $mapel->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelajaran ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-black rounded-lg transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
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
    </div>
</x-app-layout>
