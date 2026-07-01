<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Ujian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Jadwal Ujian</h3>
                        <a href="{{ route('ujian.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            + Tambah Ujian
                        </a>
                    </div>

                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 w-12 text-center">No</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Judul Ujian</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Mata Pelajaran</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Tanggal</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Durasi</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ujian as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-4 py-2 font-semibold">{{ $item->judul_ujian }}
                                    </td>

                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $item->mataPelajaran->nama_pelajaran }}</td>

                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        {{ \Carbon\Carbon::parse($item->tanggal_ujian)->format('d/m/Y H:i') }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->durasi_menit }}
                                        Menit</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('ujian.edit', $item->id) }}"
                                                class="text-yellow-600 hover:text-yellow-800 hover:underline font-semibold">Edit</a>

                                            <form action="{{ route('ujian.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ujian ini beserta seluruh soal di dalamnya?');">
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
                                    <td colspan="6"
                                        class="border border-gray-300 px-4 py-6 text-center text-gray-500 italic">
                                        Belum ada jadwal ujian.
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
