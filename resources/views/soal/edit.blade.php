<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Soal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('soal.update', $soal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="ujian_id" class="block text-gray-700 text-sm font-bold mb-2">Tujuan Ujian:</label>
                            <select name="ujian_id" id="ujian_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @foreach($ujian as $item)
                                    <option value="{{ $item->id }}" {{ $soal->ujian_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->judul_ujian }} ({{ $item->mataPelajaran->nama_pelajaran }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="teks_soal" class="block text-gray-700 text-sm font-bold mb-2">Teks Pertanyaan (Soal):</label>
                            <textarea name="teks_soal" id="teks_soal" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('teks_soal', $soal->teks_soal) }}</textarea>
                        </div>

                        <hr class="mb-6">
                        <h4 class="font-bold text-lg mb-4 text-gray-700">Pilihan Jawaban</h4>

                        @php $abjad = ['A', 'B', 'C', 'D', 'E']; @endphp

                        @foreach($soal->jawabans as $index => $jawaban)
                            <div class="flex items-center space-x-4 mb-4 bg-gray-50 p-3 rounded border">
                                <span class="font-bold text-lg w-8 text-center">{{ $abjad[$index] ?? '-' }}.</span>

                                <input type="text" name="pilihan[{{ $index }}]" value="{{ old('pilihan.'.$index, $jawaban->teks_jawaban) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>

                                <label class="flex items-center cursor-pointer bg-blue-100 hover:bg-blue-200 px-3 py-2 rounded">
                                    <input type="radio" name="kunci_benar" value="{{ $index }}" {{ $jawaban->is_benar ? 'checked' : '' }} required class="w-5 h-5 text-blue-600 form-radio focus:ring-blue-500">
                                    <span class="ml-2 font-semibold text-blue-800 text-sm whitespace-nowrap">Kunci Benar</span>
                                </label>
                            </div>
                        @endforeach

                        <div class="flex items-center justify-between mt-8">
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150">
                                Perbarui Soal
                            </button>
                            <a href="{{ route('soal.index') }}" class="font-bold text-sm text-gray-500 hover:text-gray-800">
                                Batal & Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
