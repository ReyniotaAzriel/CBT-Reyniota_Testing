<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'CBT App') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        <!-- Scripts & Livewire Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <!-- AlpineJS x-data: sidebarOpen untuk mobile, sidebarExpanded untuk minimize/maximize di desktop -->
    <body class="font-sans antialiased bg-[#f4f7fe]" x-data="{ sidebarOpen: false, sidebarExpanded: true }">
        <div class="flex h-screen overflow-hidden">

            <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden backdrop-blur-sm" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak></div>

            <!-- SIDEBAR KIRI (COLLAPSIBLE) -->
            <aside :class="[
                       sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                       sidebarExpanded ? 'lg:w-72' : 'lg:w-20'
                   ]"
                   class="fixed inset-y-0 left-0 z-50 bg-[#5c54d8] text-white transition-all duration-300 lg:static lg:translate-x-0 flex flex-col shadow-2xl lg:shadow-none border-r border-indigo-700/50">

                <!-- Logo & Tombol Lipat (Collapse Toggle) -->
                <div class="flex items-center justify-between h-20 border-b border-indigo-400/30 px-4 shrink-0">
                    <div class="flex items-center gap-3 bg-white/10 px-3 py-2 rounded-xl backdrop-blur-sm w-full justify-center overflow-hidden transition-all">
                        <span class="font-black text-xl tracking-wider text-white drop-shadow-md whitespace-nowrap" :class="sidebarExpanded ? 'block' : 'lg:hidden'">CBT <span class="text-[#ffb020]">OTA</span></span>
                        <span class="font-black text-lg text-white drop-shadow-md hidden" :class="sidebarExpanded ? 'hidden' : 'lg:block'">OTA</span>
                    </div>
                </div>

                <!-- Daftar Link Navigasi -->
                <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1.5 custom-scrollbar overflow-x-hidden">
                    @php
                        $userRole = strtolower(Auth::user()->roles->first()->name ?? '');
                        $isAdmin = $userRole === 'admin';
                        $isGuru = $userRole === 'guru';
                        $isSiswa = $userRole === 'siswa';
                    @endphp

                    <p class="px-3 text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-3 whitespace-nowrap" x-show="sidebarExpanded" x-transition>Menu Utama</p>

                    <a href="{{ route('dashboard') }}" title="Dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                        <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Dashboard</span>
                    </a>

                    @if($isAdmin || $isGuru)
                        <p class="px-3 text-[10px] font-black text-indigo-300 uppercase tracking-widest mt-8 mb-3 whitespace-nowrap" x-show="sidebarExpanded" x-transition>Data Master</p>
                        @if($isAdmin)
                            <a href="{{ route('users.index') }}" title="Kelola Pengguna" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('users.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Kelola Pengguna</span>
                            </a>
                        @endif
                        <a href="{{ route('mata-pelajaran.index') }}" title="Mata Pelajaran" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('mata-pelajaran.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253"></path></svg>
                            <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Mata Pelajaran</span>
                        </a>

                        <p class="px-3 text-[10px] font-black text-indigo-300 uppercase tracking-widest mt-8 mb-3 whitespace-nowrap" x-show="sidebarExpanded" x-transition>Manajemen Ujian</p>
                        <a href="{{ route('ujian.index') }}" title="Jadwal Ujian" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('ujian.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Jadwal Ujian</span>
                        </a>
                        <a href="{{ route('soal.index') }}" title="Bank Soal" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('soal.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Bank Soal</span>
                        </a>
                        <a href="{{ route('koreksi.index') }}" title="Koreksi Essay" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('koreksi.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Koreksi Essay</span>
                        </a>
                        <a href="{{ route('rekap.index') }}" title="Rekap Nilai" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('rekap.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Rekap Nilai</span>
                        </a>
                    @endif

                    @if($isAdmin || $isSiswa)
                        <p class="px-3 text-[10px] font-black text-indigo-300 uppercase tracking-widest mt-8 mb-3 whitespace-nowrap" x-show="sidebarExpanded" x-transition>Area Siswa</p>
                        <a href="{{ route('siswa.ujian.index') }}" title="Ujian Saya" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('siswa.ujian.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Ujian Saya</span>
                        </a>
                        <a href="{{ route('siswa.hasil.index') }}" title="Hasil Ujian" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('siswa.hasil.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Hasil Ujian</span>
                        </a>
                    @endif

                    @if($isAdmin || $isGuru)
                        <p class="px-3 text-[10px] font-black text-indigo-300 uppercase tracking-widest mt-8 mb-3 whitespace-nowrap" x-show="sidebarExpanded" x-transition>Sistem</p>
                        <a href="{{ route('activity-log.index') }}" title="Log Aktivitas" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ request()->routeIs('activity-log.*') ? 'bg-white/20 text-white shadow-inner border border-white/10' : 'text-indigo-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="whitespace-nowrap" x-show="sidebarExpanded" x-transition>Log Aktivitas</span>
                        </a>
                    @endif
                </nav>

                <!-- Footer Profil Sidebar -->
                <div class="p-3 border-t border-indigo-400/30 shrink-0">
                    <div class="flex items-center gap-3 bg-white/10 p-2.5 rounded-2xl overflow-hidden">
                        <div class="w-10 h-10 rounded-full bg-white text-[#5c54d8] flex items-center justify-center font-black text-lg shrink-0 overflow-hidden border-2 border-indigo-200">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <div class="overflow-hidden" x-show="sidebarExpanded" x-transition>
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-[10px] text-indigo-200 truncate">{{ Auth::user()->roles->first()->name ?? 'Guest' }}</p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- KONTEN UTAMA (KANAN) -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 z-30 shrink-0">

                    <!-- Kiri: Tombol Buka/Tutup Sidebar Desktop & Mobile -->
                    <div class="flex items-center gap-4">
                        <!-- Tombol Desktop untuk Melipat/Membuka Sidebar -->
                        <button @click="sidebarExpanded = !sidebarExpanded" title="Lipat/Buka Sidebar" class="hidden lg:flex text-gray-500 hover:text-[#5c54d8] focus:outline-none bg-gray-50 hover:bg-indigo-50 p-2.5 rounded-xl transition-colors cursor-pointer">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                        </button>

                        <!-- Tombol Mobile -->
                        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-[#5c54d8] focus:outline-none lg:hidden bg-gray-50 hover:bg-indigo-50 p-2 rounded-xl transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        @if (isset($header))
                            <div class="hidden sm:block">{{ $header }}</div>
                        @endif
                    </div>

                    <!-- Kanan: User Dropdown -->
                    <div class="flex items-center gap-4">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 focus:outline-none bg-gray-50 hover:bg-gray-100 p-2 pr-4 rounded-full border border-gray-200 transition-colors cursor-pointer">
                                <div class="w-8 h-8 rounded-full bg-[#5c54d8] text-white flex items-center justify-center font-bold text-sm overflow-hidden shadow-sm">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                    @endif
                                </div>
                                <span class="text-sm font-bold text-gray-700 hidden sm:block">{{ Auth::user()->name ?? 'User' }}</span>
                                <svg class="w-4 h-4 text-gray-500 hidden sm:block transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <!-- Menu Profil -->
                            <div x-show="open" style="display: none;" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-[#5c54d8] font-medium transition-colors">Profile Settings</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto overflow-x-hidden relative custom-scrollbar">
                    {{ $slot }}
                </main>
            </div>
        </div>
        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(156, 163, 175, 0.5); border-radius: 20px; }
            aside .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(255, 255, 255, 0.2); }
        </style>
        @livewireScripts
    </body>
</html>
