<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Master Mata Pelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Mata Pelajaran</h3>
                        <a href="{{ route('mata-pelajaran.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            + Tambah Mapel
                        </a>
                    </div>

                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left w-12">No</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Nama Pelajaran</th>
                                <th class="border border-gray-300 px-4 py-2 text-center w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mataPelajaran as $index => $mapel)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $mapel->nama_pelajaran }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('mata-pelajaran.edit', $mapel->id) }}"
                                                class="text-yellow-600 hover:text-yellow-800 hover:underline font-semibold">Edit</a>

                                            <form action="{{ route('mata-pelajaran.destroy', $mapel->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelajaran ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 hover:underline font-semibold">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="border border-gray-300 px-4 py-6 text-center text-gray-500 italic">
                                        Belum ada data mata pelajaran yang ditambahkan.
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
