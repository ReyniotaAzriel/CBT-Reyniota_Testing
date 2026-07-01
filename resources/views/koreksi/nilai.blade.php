<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                <span class="text-blue-600">Koreksi</span> Jawaban Essay
            </h2>
            <a href="{{ route('koreksi.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8 mb-10 relative overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                    <div class="text-left">
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-widest mb-2">Nama Siswa</p>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $hasilUjian->user->name }}</p>
                        <p class="text-sm font-bold text-blue-600 mt-1 bg-blue-50 inline-block px-3 py-1 rounded-md">
                            Kelas {{ $hasilUjian->user->kelas ?? '-' }} {{ $hasilUjian->user->jurusan ?? '' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Mata Ujian</p>
                        <p class="text-xl font-bold text-gray-900">{{ $hasilUjian->ujian->judul_ujian }}</p>
                    </div>
                    <div class="md:text-right">
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Nilai PG (Sementara)</p>
                        <div class="inline-block bg-blue-50 border border-blue-100 text-blue-700 px-6 py-3 rounded-2xl shadow-sm">
                            <span class="text-4xl font-black">{{ $hasilUjian->nilai_akhir }}</span>
                            <span class="text-sm font-bold ml-1 text-blue-500">Poin</span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('koreksi.simpan', $hasilUjian->id) }}" method="POST">
                @csrf

                <div class="space-y-8">
                    @forelse ($jawabanSiswas as $index => $jawaban)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">

                            <div class="bg-gray-50 border-b border-gray-100 p-6 flex items-start">
                                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-black text-lg mr-4 shrink-0 shadow-sm border border-blue-200">
                                    {{ $index + 1 }}
                                </span>
                                <p class="text-gray-800 text-lg font-medium leading-relaxed pt-1">
                                    {{ $jawaban->soal->teks_soal }}
                                </p>
                            </div>

                            <div class="p-6">
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Jawaban Siswa:
                                </p>
                                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-5 text-gray-700 italic leading-relaxed min-h-[100px]">
                                    {{ $jawaban->jawaban_teks ?? 'Siswa tidak menjawab soal ini.' }}
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="text-gray-600">
                                    <span class="font-bold text-gray-800 text-lg">Berikan Skor</span>
                                    <span class="text-sm ml-1">(Skala 0 - 100)</span>
                                </div>
                                <div class="relative w-full sm:w-auto">
                                    <input type="number"
                                           name="skor[{{ $jawaban->id }}]"
                                           min="0" max="100"
                                           class="w-full sm:w-40 bg-white border-2 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 font-black text-center text-2xl text-blue-700 py-3 pr-10 transition-colors"
                                           placeholder="0"
                                           required>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-gray-400 font-bold text-sm">/ 100</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-300">
                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-gray-500 font-medium text-lg">Tidak ada jawaban essay ditemukan untuk siswa ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-blue font-black py-4 px-10 rounded-2xl shadow-xl shadow-green-200 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 active:scale-95 text-lg w-full md:w-auto border-2 border-green-700">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        SIMPAN NILAI & SELESAIKAN
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
