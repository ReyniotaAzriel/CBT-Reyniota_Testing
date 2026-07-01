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
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-500">
                        <div class="p-6 text-gray-900">
                            <h4 class="font-bold text-lg mb-2 text-blue-700">{{ $item->judul_ujian }}</h4>
                            <div class="text-sm text-gray-600 mb-4 space-y-1">
                                <p><span class="font-semibold">Mata Pelajaran:</span>
                                    {{ $item->mataPelajaran->nama_pelajaran }}</p>
                                <p><span class="font-semibold">Jadwal:</span>
                                    {{ \Carbon\Carbon::parse($item->tanggal_ujian)->format('d M Y - H:i') }}</p>
                                <p><span class="font-semibold">Durasi:</span> {{ $item->durasi_menit }} Menit</p>
                            </div>

                            <a href="{{ route('siswa.ujian.mulai', $item->id) }}"
                                class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                                Mulai Kerjakan
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-6 rounded-lg shadow-sm text-center text-gray-500 italic">
                        Belum ada jadwal ujian yang tersedia saat ini.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
