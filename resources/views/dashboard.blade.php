<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            <span class="text-blue-600">Dashboard</span> Utama
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden transform transition duration-500 hover:scale-[1.01]">
                <div class="p-8 md:p-10 bg-gradient-to-r from-blue-600 to-indigo-800 text-white flex justify-between items-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 opacity-20">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"></path></svg>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-3xl font-extrabold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-blue-100 text-lg max-w-2xl">Pantau aktivitas ujian, kelola bank soal, dan evaluasi hasil belajar siswa dengan mudah melalui panel kendali ini.</p>

                        <div class="mt-6 inline-flex items-center px-4 py-2 bg-white/20 rounded-lg border border-white/30 backdrop-blur-sm">
                            <span class="text-sm font-bold text-white uppercase tracking-wider">Peran Anda:</span>
                            <span class="ml-2 px-3 py-1 bg-white text-blue-800 text-xs font-black rounded-md uppercase">
                                {{ Auth::user()->roles->first()->name ?? 'Administrator' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-blue-300 transition-colors">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Total Siswa</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $totalSiswa }}</h4>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-green-300 transition-colors">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Total Guru</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $totalGuru }}</h4>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-purple-300 transition-colors">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Jadwal Ujian</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $totalUjian }}</h4>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-orange-300 transition-colors">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">Mata Pelajaran</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $totalMapel }}</h4>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
