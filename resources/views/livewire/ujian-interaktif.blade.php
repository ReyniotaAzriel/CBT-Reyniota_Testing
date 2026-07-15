<div>
    @if ($tokenValid)
        {{-- Arena Ujian --}}
        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Judul Ujian & Timer (Alpine.js) --}}
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6 flex flex-col md:flex-row justify-between items-center gap-4"
                    x-data="timer({{ $sisaDetik }})" x-init="startTimer()">
                    <h2 class="font-bold text-2xl text-gray-800 text-center md:text-left">
                        Ujian: <span class="text-blue-600">{{ $ujian->judul_ujian }}</span>
                    </h2>

                    {{-- Kotak Waktu Digital --}}
                    <div class="flex items-center px-6 py-3 rounded-2xl border-2 transition-colors duration-300"
                        :class="timeLeft < 300 ? 'bg-red-50 border-red-500 text-red-700 animate-pulse' :
                            'bg-gray-800 border-gray-800 text-white'">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-2xl font-black font-mono tracking-wider" x-text="formatTime(timeLeft)"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">

                    {{-- Kiri: Soal (Mengambil 3 kolom) --}}
                    <div class="lg:col-span-3 bg-white overflow-hidden shadow-sm rounded-lg p-6">
                        @if (isset($soals) && count($soals) > 0)
                            <div wire:key="soal-container-{{ $soals[$soalAktif]->id }}">
                                <div class="mb-4 border-b pb-4">
                                    <h3 class="text-lg font-bold text-gray-500 uppercase tracking-wider">
                                        Pertanyaan No. {{ $soalAktif + 1 }}
                                    </h3>
                                    <p class="text-gray-900 mt-4 text-xl font-medium leading-relaxed">
                                        {{ $soals[$soalAktif]->teks_soal }}
                                    </p>
                                </div>

                                <div class="mt-6 space-y-4">
                                    @if ($soals[$soalAktif]->tipe_soal == 'essay')
                                        <textarea wire:model.live.debounce.500ms="jawabanSiswa.{{ $soals[$soalAktif]->id }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg p-4"
                                            rows="6" placeholder="Ketik jawaban Anda di sini..."></textarea>
                                    @else
                                        <div class="space-y-3">
                                            @foreach ($soals[$soalAktif]->jawabans as $opsi)
                                                @php
                                                    $opsiDipilih =
                                                        isset($jawabanSiswa[$soals[$soalAktif]->id]) &&
                                                        $jawabanSiswa[$soals[$soalAktif]->id] == $opsi->id;
                                                @endphp
                                                <label wire:key="opsi-{{ $opsi->id }}"
                                                    class="flex items-center p-4 border rounded-lg cursor-pointer transition-colors duration-200 {{ $opsiDipilih ? 'bg-blue-100 border-blue-500 ring-2 ring-blue-200' : 'bg-white border-gray-300 hover:bg-gray-50' }}">
                                                    <input type="radio"
                                                        wire:click="simpanJawaban({{ $soals[$soalAktif]->id }}, {{ $opsi->id }})"
                                                        name="soal_{{ $soals[$soalAktif]->id }}"
                                                        value="{{ $opsi->id }}"
                                                        class="w-5 h-5 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                                        {{ $opsiDipilih ? 'checked' : '' }}>
                                                    <span
                                                        class="ml-4 text-gray-800 text-lg">{{ $opsi->teks_jawaban }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- Navigasi Sebelumnya/Selanjutnya --}}
                                <div class="flex justify-between items-center mt-10 pt-6 border-t border-gray-100">
                                    @if ($soalAktif > 0)
                                        <button type="button" wire:click="gantiSoal({{ $soalAktif - 1 }})"
                                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded shadow transition">
                                            &laquo; Sebelumnya
                                        </button>
                                    @else
                                        <div></div>
                                    @endif

                                    @if ($soalAktif < count($soals) - 1)
                                        <button type="button" wire:click="gantiSoal({{ $soalAktif + 1 }})"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                            Selanjutnya &raquo;
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-10">
                                <p class="text-red-500 font-bold text-lg">Soal ujian belum tersedia.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Kanan: Navigasi Soal (Mengambil 1 kolom) --}}
                    <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm rounded-lg p-4 sticky top-6">
                        <h4 class="font-bold text-center mb-4 text-gray-700 border-b pb-2 text-md">Navigasi Soal</h4>
                        <div class="grid grid-cols-4 sm:grid-cols-5 lg:grid-cols-4 gap-2">
                            @foreach ($soals as $index => $item)
                                @php
                                    $isAktif = $soalAktif == $index;
                                    $sudahDijawab = isset($jawabanSiswa[$item->id]) && !empty($jawabanSiswa[$item->id]);
                                @endphp
                                <button type="button" wire:click="gantiSoal({{ $index }})"
                                    class="w-10 h-10 flex items-center justify-center rounded font-bold border transition-colors
                                    {{ $isAktif ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-300' : ($sudahDijawab ? 'bg-green-500 text-white border-green-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100') }}">
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>
                        <hr class="my-6">
                        <button type="button" onclick="konfirmasiSelesai()"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded shadow-lg transition-transform transform hover:scale-[1.02] text-sm uppercase tracking-wide">
                            Selesai & Kumpulkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Gerbang Ujian --}}
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-10 border border-gray-100">
                <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-6">Gerbang Ujian</h2>
                @if (session()->has('error_token'))
                    <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 text-center font-bold">
                        {{ session('error_token') }}
                    </div>
                @endif
                <input wire:model="inputToken" type="text"
                    class="w-full text-center text-4xl tracking-widest font-black uppercase bg-gray-50 border border-gray-300 rounded-2xl py-5 mb-6 outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="••••••" maxlength="6" autofocus>
                <button wire:click="verifikasiToken"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-200 transition-transform transform hover:scale-[1.02] active:scale-[0.98] text-lg uppercase tracking-wider">
                    Verifikasi & Masuk
                </button>
            </div>
        </div>
    @endif

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- LOGIKA TIMER ALPINE.JS ---
        document.addEventListener('alpine:init', () => {
            Alpine.data('timer', (sisaDetik) => ({
                timeLeft: sisaDetik, // Langsung pakai sisa detik dari server, nggak perlu dikali 60 lagi
                intervalId: null,

                startTimer() {
                    this.intervalId = setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        } else {
                            this.stopTimer();
                            this.waktuHabis();
                        }
                    }, 1000);
                },

                stopTimer() {
                    clearInterval(this.intervalId);
                },

                formatTime(seconds) {
                    const h = String(Math.floor(seconds / 3600)).padStart(2, '0');
                    const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
                    // Tambahkan Math.floor di sini agar detiknya bulat sempurna!
                    const s = String(Math.floor(seconds % 60)).padStart(2, '0');
                    return `${h}:${m}:${s}`;
                },

                waktuHabis() {
                    Swal.fire({
                        title: 'WAKTU HABIS!',
                        text: 'Sistem akan otomatis mengumpulkan jawaban Anda.',
                        icon: 'warning',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timer: 3000, // Tunggu 3 detik biar siswa sadar
                        didClose: () => {
                            Swal.showLoading();
                            @this.call('kumpulkanUjian'); // Panggil PHP untuk kumpul paksa
                        }
                    });
                }
            }));
        });

        // --- LOGIKA ANTI CURANG & KONFIRMASI (Tetap Sama) ---
        document.addEventListener('livewire:initialized', () => {
            let peringatanCount = 0;
            const maxPeringatan = 2;

            // Event listener untuk mendeteksi perubahan visibilitas halaman
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    // Tab sedang disembunyikan (siswa pindah tab)
                    peringatanCount++;

                    // 1. LAPORKAN KE SERVER BUAT POTONG NILAI!
                    @this.call('tambahPelanggaran');

                    if (peringatanCount >= maxPeringatan) {
                        // Peringatan Final (Langsung Kumpul)
                        Swal.fire({
                            icon: 'error',
                            title: 'PELANGGARAN MAKSIMAL!',
                            html: `Anda telah terdeteksi meninggalkan halaman ujian sebanyak <b>${maxPeringatan} kali</b>.<br><br>Sistem sekarang akan mengakhiri ujian Anda secara paksa dan memberikan penalti nilai!`,
                            confirmButtonText: 'Kumpulkan Ujian',
                            confirmButtonColor: '#dc2626',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then((result) => {
                            @this.call('kumpulkanUjian');
                        });
                    } else {
                        // Peringatan Biasa (Sekaligus Info Pemotongan Nilai)
                        Swal.fire({
                            icon: 'warning',
                            title: 'TERDETEKSI KECURANGAN!',
                            html: `Anda mencoba membuka tab atau aplikasi lain.<br><br>Ini adalah peringatan ke-<b><span class="text-red-600 text-xl">${peringatanCount}</span></b> dari maksimal <b>${maxPeringatan}</b>.<br><br><span class="text-red-600 font-bold">NILAI ANDA TELAH DIKURANGI OTOMATIS SEBAGAI PENALTI!</span>`,
                            confirmButtonText: 'Saya Mengerti',
                            confirmButtonColor: '#f59e0b',
                            allowOutsideClick: false,
                        });
                    }
                }
            });

            document.addEventListener('contextmenu', event => event.preventDefault());
            document.addEventListener('copy', event => {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak!',
                    text: 'Fitur Copy-Paste dinonaktifkan untuk mencegah kecurangan!',
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#3b82f6',
                    timer: 3000
                });
            });
        });

        function konfirmasiSelesai() {
            Swal.fire({
                title: 'Yakin ingin mengumpulkan?',
                html: "Pastikan Anda sudah mengecek kembali semua jawaban.<br>Ujian yang sudah dikumpulkan <b>tidak dapat diulang!</b>",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Kumpulkan Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                backdrop: `rgba(0,0,0,0.6)`
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        html: 'Sistem sedang menyimpan dan menghitung nilai Anda.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    @this.call('kumpulkanUjian');
                }
            });
        }
    </script>
</div>
