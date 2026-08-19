<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                Koreksi <span class="text-[#5c54d8]">Jawaban Essay</span>
            </h2>
            <!-- Tombol Kembali sudah dihapus sesuai permintaan -->
        </div>
    </x-slot>

    <div class="py-12 bg-[#f4f7fe] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Info Siswa & Nilai Sementara -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-10 relative overflow-hidden">
                <!-- Dekorasi Background -->
                <svg class="absolute right-0 top-0 text-indigo-50/50 w-64 h-64 transform translate-x-10 -translate-y-10 z-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                    <div class="text-left border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Nama Siswa</p>
                        <p class="text-2xl font-black text-gray-900">{{ $hasilUjian->user->name }}</p>
                        <p class="text-[11px] font-bold text-[#5c54d8] mt-2 bg-indigo-50 inline-block px-3 py-1.5 rounded-lg border border-indigo-100/50 uppercase tracking-wider">
                            Kelas {{ $hasilUjian->user->kelas ?? '-' }} {{ $hasilUjian->user->jurusan ?? '' }}
                        </p>
                    </div>
                    <div class="border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Mata Ujian</p>
                        <p class="text-xl font-bold text-gray-800 leading-snug">{{ $hasilUjian->ujian->judul_ujian }}</p>
                    </div>
                    <div class="md:text-right flex flex-col justify-center">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Nilai PG (Sementara)</p>
                        <div class="inline-block bg-indigo-50/50 border border-indigo-100 text-[#5c54d8] px-6 py-3 rounded-2xl shadow-sm w-max md:ml-auto">
                            <span class="text-4xl font-black">{{ $hasilUjian->nilai_akhir }}</span>
                            <span class="text-xs font-bold ml-1 text-indigo-400 uppercase tracking-widest">Poin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Khusus Jawaban Essay -->
            @php
                $jawabanEssays = $jawabanSiswas->filter(function($jawaban) {
                    return $jawaban->soal->tipe_soal === 'essay';
                })->values();
            @endphp

            <form action="{{ route('koreksi.simpan', $hasilUjian->id) }}" method="POST">
                @csrf

                <div class="space-y-8">
                    @forelse ($jawabanEssays as $index => $jawaban)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">

                            <!-- Teks Soal -->
                            <div class="bg-gray-50/50 border-b border-gray-50 p-6 md:p-8 flex items-start">
                                <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-[#5c54d8] font-black text-xl mr-5 shrink-0 shadow-sm border border-indigo-100/50">
                                    {{ $index + 1 }}
                                </span>
                                <p class="text-gray-800 text-lg font-medium leading-relaxed pt-2">
                                    {{ $jawaban->soal->teks_soal }}
                                </p>
                            </div>

                            <!-- Jawaban Siswa -->
                            <div class="p-6 md:p-8">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Jawaban Siswa:
                                </p>
                                <div class="bg-indigo-50/30 border-l-4 border-[#5c54d8] rounded-r-2xl p-6 text-gray-700 italic leading-relaxed min-h-[100px] border border-y-gray-100 border-r-gray-100">
                                    {{ $jawaban->jawaban_teks ?? 'Siswa tidak menjawab soal ini.' }}
                                </div>
                            </div>

                            <!-- Input Skor -->
                            <div class="bg-gray-50/80 p-6 md:px-8 md:py-6 border-t border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="text-gray-600">
                                    <span class="font-black text-gray-800 text-lg">Berikan Skor</span>
                                    <span class="text-xs font-bold text-gray-400 ml-2 uppercase tracking-wider">(Skala 0 - 100)</span>
                                </div>
                                <div class="relative w-full sm:w-auto">
                                    <input type="number"
                                           name="skor[{{ $jawaban->id }}]"
                                           min="0" max="100"
                                           class="w-full sm:w-48 bg-white border border-gray-200 rounded-xl shadow-sm focus:border-[#5c54d8] focus:ring focus:ring-indigo-100 focus:ring-opacity-50 font-black text-center text-2xl text-[#5c54d8] py-4 pr-12 transition-colors"
                                           placeholder="0"
                                           required>
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                        <span class="text-gray-300 font-bold text-base">/ 100</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h4 class="text-xl font-black text-gray-800 mb-1">Tidak Ada Soal Essay</h4>
                            <p class="text-gray-500 font-medium text-sm">Siswa ini tidak memiliki jawaban essay yang perlu dikoreksi.</p>
                        </div>
                    @endforelse
                </div>

                @if($jawabanEssays->isNotEmpty())
                    <div class="mt-10 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center justify-center bg-[#5c54d8] hover:bg-indigo-700 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 active:scale-95 text-lg w-full md:w-auto tracking-wide border border-transparent">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            SIMPAN NILAI & SELESAIKAN
                        </button>
                    </div>
                @endif

            </form>
        </div>
    </div>
</x-app-layout>
