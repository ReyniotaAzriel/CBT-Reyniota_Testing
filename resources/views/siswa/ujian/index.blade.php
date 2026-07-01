<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lobi Ujian Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-600">Silakan pilih ujian yang tersedia di bawah ini untuk mulai mengerjakan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($ujian as $item)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-500 transition-transform transform hover:-translate-y-1 hover:shadow-lg duration-300">
                        <div class="p-6 text-gray-900">
                            <h4 class="font-bold text-lg mb-2 text-blue-700">{{ $item->judul_ujian }}</h4>
                            <div class="text-sm text-gray-600 mb-5 space-y-2">
                                <p class="flex items-center"><span class="font-semibold w-32">Mata Pelajaran</span> <span class="mr-2">:</span>
                                    {{ $item->mataPelajaran->nama_pelajaran }}</p>
                                <p class="flex items-center"><span class="font-semibold w-32">Jadwal</span> <span class="mr-2">:</span>
                                    {{ \Carbon\Carbon::parse($item->tanggal_ujian)->format('d M Y - H:i') }}</p>
                                <p class="flex items-center"><span class="font-semibold w-32">Durasi</span> <span class="mr-2">:</span> {{ $item->durasi_menit }} Menit</p>
                            </div>

                            @if(in_array($item->id, $ujianSelesai) && !auth()->user()->hasRole('admin'))
                                <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-2.5 px-4 rounded-lg shadow-inner cursor-not-allowed flex items-center justify-center border border-gray-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7z"></path></svg>
                                    Sudah Dikerjakan
                                </button>
                            @else
                                <a href="{{ route('siswa.ujian.mulai', $item->id) }}" class="flex w-full items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-md transition duration-150 transform hover:scale-105 active:scale-95">
                                    Mulai Kerjakan
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-10 rounded-lg shadow-sm text-center flex flex-col items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-gray-500 font-medium text-lg">Belum ada jadwal ujian yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
