<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-black text-gray-800">Detail Koreksi: {{ $hasil->user->name }}</h2>
                <a href="{{ route('rekap.index') }}" class="text-blue-600 font-bold hover:underline">« Kembali ke Rekap</a>
            </div>

            <div class="space-y-6">
                @foreach($hasil->ujian->soals as $index => $soal)
                    @php
                        $jawaban = $jawabanSiswa->get($soal->id);
                        $kunci = $soal->jawabans->where('is_benar', true)->first();
                        $isBenar = $jawaban && ($jawaban->jawaban_id == ($kunci->id ?? null));
                    @endphp

                    <div class="bg-white p-6 rounded-2xl shadow-sm border {{ $isBenar ? 'border-green-200' : 'border-red-200' }}">
                        <p class="font-bold text-gray-700">Soal No. {{ $index + 1 }}</p>
                        <p class="mt-2 text-lg">{{ $soal->teks_soal }}</p>

                        <div class="mt-4 p-4 rounded-xl {{ $isBenar ? 'bg-green-50' : 'bg-red-50' }}">
                            <p class="text-sm font-bold {{ $isBenar ? 'text-green-700' : 'text-red-700' }}">
                                {{ $isBenar ? 'Jawaban Anda Benar' : 'Jawaban Anda Salah' }}
                            </p>
                            @if(!$isBenar)
                                <p class="text-sm text-gray-600">Kunci Jawaban: <strong>{{ $kunci->teks_jawaban ?? 'Tidak ada kunci' }}</strong></p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
