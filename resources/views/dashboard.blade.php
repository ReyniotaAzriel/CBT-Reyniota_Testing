<x-app-layout>
    <!-- Header Title yang nampil di sebelah tombol collapse sidebar -->
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Dashboard <span class="text-blue-600">Utama</span>
        </h2>
    </x-slot>

    <!-- Wrapper utama dengan Alpine.js -->
    <div x-data="{ showSystemModal: false }" class="py-8 bg-[#f4f7fe] min-h-screen relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- BAGIAN KIRI -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Banner -->
                    <div class="bg-[#5c54d8] rounded-[2rem] p-8 md:p-10 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between shadow-lg shadow-indigo-200">
                        <svg class="absolute right-0 top-0 h-full w-2/3 md:w-1/2 text-white/10 transform translate-x-20" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <path d="M0,100 C30,100 40,0 100,0 L100,100 Z"></path>
                        </svg>

                        <div class="relative z-10 w-full md:w-2/3">
                            <h3 class="text-3xl font-bold mb-3">Hello {{ Auth::user()->name }}!</h3>
                            <p class="text-indigo-100 text-sm md:text-base mb-6 leading-relaxed">
                                Saat ini ada <strong>{{ $totalUjian ?? 0 }}</strong> jadwal ujian yang terdaftar.<br>
                                Pastikan seluruh sistem dan bank soal siap digunakan oleh siswa.
                            </p>
                            <a href="#" class="inline-block bg-[#ffb020] hover:bg-yellow-500 text-white font-bold py-2.5 px-6 rounded-xl transition-all transform hover:-translate-y-0.5">
                                Read more
                            </a>
                        </div>
                    </div>

                    <!-- Progress List & View All Modal Trigger -->
                    <div>
                        <div class="flex justify-between items-center mb-5 px-2">
                            <h4 class="font-extrabold text-gray-800 text-lg">System Overview</h4>
                            <button @click="showSystemModal = true" type="button" class="text-xs font-bold text-white bg-[#5c54d8] hover:bg-indigo-700 px-5 py-2 rounded-full shadow-sm transition-colors focus:outline-none cursor-pointer">
                                View All
                            </button>
                        </div>

                        <div class="space-y-4">
                            <!-- Item: Siswa -->
                            <div class="bg-white rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between shadow-sm border border-gray-100/50 hover:shadow-md transition-shadow gap-4 sm:gap-0">
                                <div class="flex items-center gap-4 w-full sm:w-1/3">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold">SI</div>
                                    <span class="font-bold text-gray-700 text-sm">Data Siswa</span>
                                </div>
                                <div class="w-full sm:w-1/3 sm:text-center">
                                    <span class="text-[11px] font-bold text-orange-600 bg-orange-50 border border-orange-100 px-3 py-1.5 rounded-md">Total: {{ $totalSiswa ?? 0 }} Terdaftar</span>
                                </div>
                                <div class="w-full sm:w-1/3 flex justify-start sm:justify-end items-center gap-3">
                                    <span class="flex h-2 w-2 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span></span>
                                    <span class="text-xs font-bold text-gray-500">Active</span>
                                </div>
                            </div>
                            <!-- Item: Guru -->
                            <div class="bg-white rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between shadow-sm border border-gray-100/50 hover:shadow-md transition-shadow gap-4 sm:gap-0">
                                <div class="flex items-center gap-4 w-full sm:w-1/3">
                                    <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center font-bold">GU</div>
                                    <span class="font-bold text-gray-700 text-sm">Tenaga Pengajar</span>
                                </div>
                                <div class="w-full sm:w-1/3 sm:text-center">
                                    <span class="text-[11px] font-bold text-green-600 bg-green-50 border border-green-100 px-3 py-1.5 rounded-md">Total: {{ $totalGuru ?? 0 }} Guru</span>
                                </div>
                                <div class="w-full sm:w-1/3 flex justify-start sm:justify-end items-center gap-3">
                                    <span class="flex h-2 w-2 relative"><span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-400"></span></span>
                                    <span class="text-xs font-bold text-gray-500">Standby</span>
                                </div>
                            </div>
                            <!-- Item: Ujian -->
                            <div class="bg-white rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between shadow-sm border border-gray-100/50 hover:shadow-md transition-shadow gap-4 sm:gap-0">
                                <div class="flex items-center gap-4 w-full sm:w-1/3">
                                    <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center font-bold">UJ</div>
                                    <span class="font-bold text-gray-700 text-sm">Jadwal Ujian</span>
                                </div>
                                <div class="w-full sm:w-1/3 sm:text-center">
                                    <span class="text-[11px] font-bold text-purple-600 bg-purple-50 border border-purple-100 px-3 py-1.5 rounded-md">Total: {{ $totalUjian ?? 0 }} Jadwal</span>
                                </div>
                                <div class="w-full sm:w-1/3 flex justify-start sm:justify-end items-center gap-3">
                                    <span class="flex h-2 w-2 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span></span>
                                    <span class="text-xs font-bold text-gray-500">Running</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN KANAN (Sidebar Widgets: Kalender & Profil) -->
                <div class="space-y-8">

                    <!-- 1. Widget Kalender Fungsional -->
                    <div x-data="{
                        month: new Date().getMonth(),
                        year: new Date().getFullYear(),
                        no_of_days: [],
                        blankdays: [],
                        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                        init() {
                            this.getNoOfDays();
                        },
                        isToday(date) {
                            const today = new Date();
                            const d = new Date(this.year, this.month, date);
                            return today.toDateString() === d.toDateString();
                        },
                        getNoOfDays() {
                            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                            let dayOfWeek = new Date(this.year, this.month, 1).getDay();
                            let prevMonthDays = new Date(this.year, this.month, 0).getDate();

                            let blankdaysArray = [];
                            for (var i = 1; i <= dayOfWeek; i++) {
                                blankdaysArray.push(prevMonthDays - dayOfWeek + i);
                            }

                            let daysArray = [];
                            for (var i = 1; i <= daysInMonth; i++) {
                                daysArray.push(i);
                            }

                            this.blankdays = blankdaysArray;
                            this.no_of_days = daysArray;
                        },
                        nextMonth() {
                            if (this.month == 11) {
                                this.month = 0;
                                this.year++;
                            } else {
                                this.month++;
                            }
                            this.getNoOfDays();
                        },
                        prevMonth() {
                            if (this.month == 0) {
                                this.month = 11;
                                this.year--;
                            } else {
                                this.month--;
                            }
                            this.getNoOfDays();
                        }
                    }" x-init="init()" class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100/50">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="font-bold text-gray-800 text-sm" x-text="monthNames[month] + ' ' + year"></h4>
                            <div class="flex gap-2">
                                <button type="button" @click="prevMonth()" class="w-7 h-7 rounded-lg bg-indigo-50 text-[#5c54d8] flex items-center justify-center text-sm font-bold hover:bg-indigo-100 cursor-pointer">&larr;</button>
                                <button type="button" @click="nextMonth()" class="w-7 h-7 rounded-lg bg-indigo-50 text-[#5c54d8] flex items-center justify-center text-sm font-bold hover:bg-indigo-100 cursor-pointer">&rarr;</button>
                            </div>
                        </div>

                        <!-- Header Hari -->
                        <div class="grid grid-cols-7 gap-1 text-center mb-4">
                            <div class="text-[9px] font-extrabold text-gray-400">SU</div>
                            <div class="text-[9px] font-extrabold text-gray-400">MO</div>
                            <div class="text-[9px] font-extrabold text-gray-400">TU</div>
                            <div class="text-[9px] font-extrabold text-gray-400">WE</div>
                            <div class="text-[9px] font-extrabold text-gray-400">TH</div>
                            <div class="text-[9px] font-extrabold text-gray-400">FR</div>
                            <div class="text-[9px] font-extrabold text-gray-400">SA</div>
                        </div>

                        <!-- Grid Tanggal -->
                        <div class="grid grid-cols-7 gap-y-4 text-center text-xs font-bold text-gray-600">
                            <template x-for="blankday in blankdays">
                                <div class="text-gray-300 flex items-center justify-center h-7" x-text="blankday"></div>
                            </template>
                            <template x-for="date in no_of_days" :key="date">
                                <div class="relative flex justify-center items-center h-7 cursor-default">
                                    <span x-show="isToday(date)" style="display: none;" class="absolute bg-[#5c54d8] text-white w-7 h-7 rounded-full flex items-center justify-center shadow-md shadow-indigo-200 z-10" x-text="date"></span>
                                    <span x-show="!isToday(date)" class="relative z-0 hover:text-[#5c54d8] transition-colors" x-text="date"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- 2. Widget Profile Card -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100/50 text-center relative overflow-hidden">
                        <div class="h-24 bg-gradient-to-r from-gray-50 to-indigo-50 absolute top-0 left-0 w-full rounded-t-3xl"></div>

                        <div class="relative z-10">
                            <div class="w-20 h-20 mx-auto bg-white rounded-2xl mb-4 overflow-hidden shadow-md p-1">
                                @if(Auth::user()->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <div class="w-full h-full bg-[#5c54d8] text-white rounded-xl flex items-center justify-center text-3xl font-black">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <h4 class="font-bold text-gray-900 text-lg">{{ Auth::user()->name ?? 'Administrator' }}</h4>
                            <p class="text-xs text-gray-500 font-medium mb-6 uppercase tracking-wider">
                                {{ Auth::user()->roles->first()->name ?? 'ADMIN' }}
                            </p>

                            <div class="space-y-4 text-left border-t border-gray-100/80 pt-5 mt-5">
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="font-bold text-gray-800">Email</span>
                                    <span class="text-gray-500">{{ Auth::user()->email ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="font-bold text-gray-800">Status Akun</span>
                                    <span class="text-green-500 font-bold bg-green-50 px-2 py-0.5 rounded">Verified</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- MODAL POP-UP SYSTEM OVERVIEW -->
        <div x-show="showSystemModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4 sm:px-6">
            <div x-show="showSystemModal"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm cursor-pointer" @click="showSystemModal = false">
            </div>

            <div x-show="showSystemModal"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl p-6 md:p-8 overflow-hidden z-10">

                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl md:text-2xl font-black text-gray-800">Detail System Overview</h3>
                    <button type="button" @click="showSystemModal = false" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-full cursor-pointer focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                    <div class="p-5 bg-blue-50/50 rounded-2xl border border-blue-100">
                        <h4 class="font-bold text-blue-900 mb-2">Data Siswa</h4>
                        <p class="text-sm text-blue-800">Total: <strong class="text-lg">{{ $totalSiswa ?? 0 }}</strong></p>
                    </div>
                    <div class="p-5 bg-green-50/50 rounded-2xl border border-green-100">
                        <h4 class="font-bold text-green-900 mb-2">Tenaga Pengajar</h4>
                        <p class="text-sm text-green-800">Total: <strong class="text-lg">{{ $totalGuru ?? 0 }}</strong></p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="button" @click="showSystemModal = false" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-xl transition-colors focus:outline-none cursor-pointer">
                        Tutup Panel
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
