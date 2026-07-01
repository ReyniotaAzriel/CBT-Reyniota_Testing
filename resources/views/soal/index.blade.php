<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            <span class="text-blue-600">Bank</span> Soal
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900">Kelola Pertanyaan Ujian</h3>
                    <p class="text-sm text-gray-500 mt-1">Pilih mata ujian di bawah ini untuk melihat dan mengelola soalnya.</p>
                </div>
                <a href="{{ route('soal.create') }}"
                    class="mt-4 md:mt-0 inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Soal Baru
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r-lg shadow-sm mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($soal->groupBy('ujian_id') as $ujianId => $kumpulanSoal)
                    @php $ujian = $kumpulanSoal->first()->ujian; @endphp

                    <a href="{{ route('soal.by_ujian', $ujianId) }}" class="block bg-white rounded-3xl shadow-sm border border-gray-200 hover:shadow-xl hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden group">
                        <div class="p-6 bg-gradient-to-br from-white to-blue-50/50">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div class="bg-white border border-gray-100 px-3 py-1 rounded-full shadow-sm flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                    <span class="text-xs font-bold text-gray-600">Aktif</span>
                                </div>
                            </div>

                            <h4 class="text-xl font-extrabold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors line-clamp-2">
                                {{ $ujian->judul_ujian }}
                            </h4>
                            <p class="text-sm text-gray-500 font-medium">Jadwal Ujian</p>

                            <div class="mt-6 pt-5 border-t border-gray-100 flex justify-between items-center">
                                <span class="text-gray-600 font-semibold text-sm">Total Pertanyaan</span>
                                <span class="px-4 py-1.5 bg-blue-600 text-white font-black text-sm rounded-xl shadow-sm">
                                    {{ $kumpulanSoal->count() }} Soal
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white rounded-3xl shadow-sm border-2 border-dashed border-gray-300 p-16 text-center flex flex-col items-center">
                        <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Soal</h3>
                        <p class="text-gray-500 max-w-md mb-6">Bank soal Anda masih kosong. Silakan tambahkan soal baru terlebih dahulu.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
