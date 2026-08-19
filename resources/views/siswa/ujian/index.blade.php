<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Lobi <span class="text-[#5c54d8]">Ujian Siswa</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f4f7fe] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            

            <!-- Grid Daftar Ujian -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($ujian as $item)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow relative flex flex-col">
                        <!-- Garis Dekorasi Atas -->
                        <div class="h-2 w-full bg-gradient-to-r from-[#5c54d8] to-indigo-400"></div>

                        <div class="p-6 md:p-8 flex flex-col flex-1">
                            <!-- Judul & Badge Mapel -->
                            <h4 class="font-black text-xl text-gray-800 mb-2 line-clamp-2">{{ $item->judul_ujian }}</h4>
                            <div class="inline-block px-3 py-1 bg-indigo-50 border border-indigo-100 text-[#5c54d8] text-[10px] font-black rounded-lg uppercase tracking-wider mb-6 w-max">
                                {{ $item->mataPelajaran->nama_pelajaran }}
                            </div>

                            <!-- Info Jadwal & Durasi -->
                            <div class="space-y-4 mb-8 flex-1">
                                <div class="flex items-center gap-3 text-sm text-gray-600 font-medium">
                                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Jadwal Ujian</span>
                                        <span class="text-gray-800 font-bold">{{ \Carbon\Carbon::parse($item->tanggal_ujian)->format('d M Y - H:i') }} WIB</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600 font-medium">
                                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Durasi Waktu</span>
                                        <span class="text-gray-800 font-bold">{{ $item->durasi_menit }} Menit</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Logika Tombol Aksi -->
                            @php
                                $waktuMulai = \Carbon\Carbon::parse($item->tanggal_ujian);
                                $sekarang = \Carbon\Carbon::now();
                                $belumMulai = $sekarang->lessThan($waktuMulai);
                            @endphp

                            <div class="mt-auto pt-4 border-t border-gray-50">
                                @if(in_array($item->id, $ujianSelesai) && !auth()->user()->hasRole('admin'))
                                    <button disabled class="w-full bg-gray-50 text-gray-400 font-bold py-3 px-4 rounded-xl cursor-not-allowed flex items-center justify-center border border-gray-200 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Sudah Dikerjakan
                                    </button>
                                @elseif($belumMulai && !auth()->user()->hasRole('admin'))
                                    <button disabled class="w-full bg-orange-50 text-orange-400 font-bold py-3 px-4 rounded-xl cursor-not-allowed flex items-center justify-center border border-orange-100 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Belum Dimulai
                                    </button>
                                    <p class="text-[11px] text-center mt-3 text-orange-500 font-bold bg-orange-50/50 py-1.5 rounded-lg border border-orange-100/50">
                                        Bisa diakses pada: <br> {{ $waktuMulai->format('d M Y, H:i') }} WIB
                                    </p>
                                @else
                                    <a href="{{ route('siswa.ujian.mulai', $item->id) }}" class="w-full inline-flex justify-center items-center bg-[#5c54d8] hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                                        Mulai Kerjakan
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-12 flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h4 class="text-xl font-black text-gray-800 mb-2">Belum Ada Ujian</h4>
                            <p class="text-gray-500 font-medium">Saat ini tidak ada jadwal ujian yang tersedia untuk Anda.</p>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
