<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                Detail <span class="text-blue-600">Soal Ujian</span>
            </h2>
            <a href="{{ route('soal.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Bank Soal
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div
                    class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white mr-4 shadow-lg shadow-blue-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Mata Ujian</p>
                            <h4 class="text-2xl font-black text-gray-900">{{ $ujian->judul_ujian }}</h4>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 mt-4 md:mt-0">
                        <span
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-100 text-blue-800 text-sm font-bold rounded-xl border border-blue-300">
                            Total: {{ $soal->count() }} Soal
                        </span>
                        <a href="{{ route('soal.create') }}"
                            class="inline-flex items-center justify-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md transition-all transform hover:scale-105">
                            + Tambah Soal Manual
                        </a>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'upload-excel')"
                            class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-lg transition-transform transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Import dari Excel
                        </button>
                        <a href="{{ asset('templates/template_soal.xlsx') }}" download
                            class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold rounded-xl shadow-md transition-all transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download Template Excel
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center w-16">No</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100">Teks Soal</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Tipe Soal</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Opsi/Kunci</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($soal as $index => $item)
                                <tr class="hover:bg-blue-50/30 transition duration-150">
                                    <td class="px-6 py-5 text-center text-gray-500 font-bold">{{ $index + 1 }}</td>
                                    <td class="px-6 py-5 text-gray-800 text-base">
                                        {{ Str::limit($item->teks_soal, 80) }}
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($item->tipe_soal == 'essay')
                                            <span
                                                class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-bold rounded-full">Essay</span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-bold rounded-full">PG</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center text-gray-600 font-medium">
                                        @if ($item->tipe_soal == 'essay')
                                            <span class="text-gray-400 italic">-</span>
                                        @else
                                            <span class="font-bold text-gray-700">{{ $item->jawabans->count() }}</span>
                                            Pilihan
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('soal.edit', $item->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-sm font-bold rounded-lg transition-colors">
                                                Edit
                                            </a>
                                            <form id="form-hapus-{{ $item->id }}" action="{{ route('soal.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="konfirmasiHapusSoal({{ $item->id }})"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-bold rounded-lg transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-500 font-medium">
                                        Ujian ini belum memiliki soal.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <x-modal name="upload-excel" :show="$errors->isNotEmpty()" focusable>
        <form method="post" action="{{ route('soal.import', $ujian->id) }}" class="p-6"
            enctype="multipart/form-data">
            @csrf
            <h2 class="text-lg font-bold text-gray-900 mb-4">
                {{ __('Import Soal via Excel') }}
            </h2>

            <div class="mb-4 text-sm text-gray-600 space-y-2">
                <p>1. Buat file Excel (.xlsx) dengan susunan kolom persis (huruf kecil) di baris pertama sebagai
                    berikut:</p>
                <div
                    class="bg-gray-100 p-3 rounded font-mono text-xs overflow-x-auto whitespace-nowrap border border-gray-300">
                    teks_soal | tipe_soal | opsi_a | opsi_b | opsi_c | opsi_d | opsi_e | kunci_jawaban
                </div>
                <p>2. Pada kolom <span class="font-bold">tipe_soal</span>, isi dengan "pg" atau "essay".</p>
                <p>3. Untuk soal "essay", kosongkan kolom opsi dan kunci jawaban.</p>
            </div>

            <div class="mt-6 border-2 border-dashed border-gray-300 rounded-xl p-6 text-center">
                <input type="file" name="file_excel" id="file_excel" accept=".xlsx, .xls, .csv"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                    required>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-primary-button class="ms-3 bg-green-600 hover:bg-green-700">
                    {{ __('Mulai Import') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiHapusSoal(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus soal ini?',
                text: "Data soal dan pilihan jawabannya akan terhapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // red-600
                cancelButtonColor: '#6b7280', // gray-500
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true, // Membalik posisi tombol agar tombol Ya ada di kanan
                customClass: {
                    popup: 'rounded-3xl shadow-xl border border-gray-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Cari form berdasarkan ID dan submit
                    document.getElementById('form-hapus-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>
