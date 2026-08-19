<div>
    @if ($tokenValid)
        {{-- Arena Ujian --}}
        <div class="py-12 bg-[#f4f7fe] min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Judul Ujian & Timer (Alpine.js) --}}
                <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-4"
                    x-data="timer({{ $sisaDetik }})" x-init="startTimer()">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Sedang Mengerjakan</p>
                        <h2 class="font-black text-2xl text-gray-900 tracking-tight">
                            {{ $ujian->judul_ujian }}
                        </h2>
                    </div>

                    {{-- Kotak Waktu Digital --}}
                    <div class="flex items-center px-6 py-3.5 rounded-2xl border-2 transition-colors duration-300 shadow-sm"
                        :class="timeLeft < 300 ? 'bg-red-50 border-red-500 text-red-600 animate-pulse' :
                            'bg-gray-900 border-gray-900 text-white'">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-2xl font-black font-mono tracking-wider" x-text="formatTime(timeLeft)"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">

                    {{-- Kiri: Soal (Mengambil 3 kolom) --}}
                    <div class="lg:col-span-3 bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8 md:p-10">
                        @if (isset($soals) && count($soals) > 0)
                            <div wire:key="soal-container-{{ $soals[$soalAktif]->id }}">
                                <div class="mb-6 border-b border-gray-100 pb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-3 py-1 bg-indigo-50 text-[#5c54d8] text-xs font-black rounded-lg uppercase tracking-wider border border-indigo-100/50">
                                            Pertanyaan No. {{ $soalAktif + 1 }} dari {{ count($soals) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-900 mt-4 text-xl font-bold leading-relaxed">
                                        {{ $soals[$soalAktif]->teks_soal }}
                                    </p>
                                </div>

                                <div class="mt-6 space-y-4">
                                    @if ($soals[$soalAktif]->tipe_soal == 'essay')
                                        <textarea wire:model.live.debounce.500ms="jawabanSiswa.{{ $soals[$soalAktif]->id }}"
                                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl shadow-sm focus:border-[#5c54d8] focus:ring-2 focus:ring-indigo-100 text-lg p-5 transition-colors"
                                            rows="6" placeholder="Ketik jawaban essay Anda di sini..."></textarea>
                                    @else
                                        <div class="space-y-3">
                                            @foreach ($soals[$soalAktif]->jawabans as $opsi)
                                                @php
                                                    $opsiDipilih =
                                                        isset($jawabanSiswa[$soals[$soalAktif]->id]) &&
                                                        $jawabanSiswa[$soals[$soalAktif]->id] == $opsi->id;
                                                @endphp
                                                <label wire:key="opsi-{{ $opsi->id }}"
                                                    class="flex items-center p-5 border-2 rounded-2xl cursor-pointer transition-all duration-200 {{ $opsiDipilih ? 'bg-indigo-50/60 border-[#5c54d8] shadow-sm' : 'bg-white border-gray-200 hover:bg-gray-50/80' }}">
                                                    <input type="radio"
                                                        wire:click="simpanJawaban({{ $soals[$soalAktif]->id }}, {{ $opsi->id }})"
                                                        name="soal_{{ $soals[$soalAktif]->id }}"
                                                        value="{{ $opsi->id }}"
                                                        class="w-5 h-5 text-[#5c54d8] focus:ring-[#5c54d8] border-gray-300 cursor-pointer"
                                                        {{ $opsiDipilih ? 'checked' : '' }}>
                                                    <span class="ml-4 text-gray-800 text-base font-semibold">{{ $opsi->teks_jawaban }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- Navigasi Sebelumnya/Selanjutnya --}}
                                <div class="flex justify-between items-center mt-10 pt-6 border-t border-gray-100">
                                    @if ($soalAktif > 0)
                                        <button type="button" wire:click="gantiSoal({{ $soalAktif - 1 }})"
                                            class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3 px-6 rounded-xl shadow-sm transition-all text-sm">
                                            &laquo; Sebelumnya
                                        </button>
                                    @else
                                        <div></div>
                                    @endif

                                    @if ($soalAktif < count($soals) - 1)
                                        <button type="button" wire:click="gantiSoal({{ $soalAktif + 1 }})"
                                            class="bg-[#5c54d8] hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all text-sm">
                                            Selanjutnya &raquo;
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-16">
                                <p class="text-gray-400 font-bold text-base">Soal ujian belum tersedia.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Kanan: Navigasi Soal (Mengambil 1 kolom) --}}
                    <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-6 sticky top-6">
                        <h4 class="font-black text-center mb-4 text-gray-800 border-b border-gray-100 pb-3 text-sm uppercase tracking-wider">Navigasi Soal</h4>
                        <div class="grid grid-cols-4 sm:grid-cols-5 lg:grid-cols-4 gap-2.5">
                            @foreach ($soals as $index => $item)
                                @php
                                    $isAktif = $soalAktif == $index;
                                    $sudahDijawab = isset($jawabanSiswa[$item->id]) && !empty($jawabanSiswa[$item->id]);
                                @endphp
                                <button type="button" wire:click="gantiSoal({{ $index }})"
                                    class="w-11 h-11 flex items-center justify-center rounded-xl font-bold border transition-all text-sm
                                    {{ $isAktif ? 'bg-[#5c54d8] text-white border-[#5c54d8] ring-2 ring-indigo-200 shadow-sm' : ($sudahDijawab ? 'bg-emerald-500 text-white border-emerald-500 shadow-sm' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100') }}">
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>
                        <hr class="my-6 border-gray-100">
                        <button type="button" onclick="konfirmasiSelesai()"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3.5 px-4 rounded-2xl shadow-lg shadow-red-200 transition-all transform hover:-translate-y-0.5 text-xs uppercase tracking-wider">
                            Selesai & Kumpulkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Gerbang Ujian --}}
        <div class="min-h-screen flex items-center justify-center bg-[#f4f7fe] py-12 px-4">
            <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-10 border border-gray-100">
                <div class="w-16 h-16 bg-indigo-50 text-[#5c54d8] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-center text-gray-900 mb-2">Gerbang Ujian</h2>
                <p class="text-sm text-gray-500 text-center font-medium mb-8">Masukkan token akses yang telah diberikan oleh pengawas atau guru.</p>

                @if (session()->has('error_token'))
                    <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-center font-bold text-sm border border-red-100">
                        {{ session('error_token') }}
                    </div>
                @endif
                <input wire:model="inputToken" type="text"
                    class="w-full text-center text-4xl tracking-widest font-black uppercase bg-gray-50 border border-gray-200 rounded-2xl py-4 mb-6 outline-none focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-all shadow-sm"
                    placeholder="••••••" maxlength="6" autofocus>
                <button wire:click="verifikasiToken"
                    class="w-full bg-[#5c54d8] hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-200 transition-transform transform hover:-translate-y-0.5 active:translate-y-0 text-sm uppercase tracking-wider">
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
                timeLeft: sisaDetik,
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
                        timer: 3000,
                        didClose: () => {
                            Swal.showLoading();
                            @this.call('kumpulkanUjian');
                        }
                    });
                }
            }));
        });

        // --- LOGIKA ANTI CURANG & KONFIRMASI ---
        document.addEventListener('livewire:initialized', () => {
            let peringatanCount = 0;
            const maxPeringatan = 2;

            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    peringatanCount++;
                    @this.call('tambahPelanggaran');

                    if (peringatanCount >= maxPeringatan) {
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
                    confirmButtonColor: '#5c54d8',
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
                confirmButtonColor: '#5c54d8',
                cancelButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Kumpulkan Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                backdrop: `rgba(0,0,0,0.6)`,
                customClass: {
                    popup: 'rounded-3xl shadow-xl'
                }
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
