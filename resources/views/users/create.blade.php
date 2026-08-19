<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">Tambah <span class="text-blue-600">Pengguna</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 md:p-10">
                    <!-- Form Utama dengan state role bawaan Alpine & ENCTYPE untuk upload file -->
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"
                        x-data="{ role: 'siswa' }">
                        @csrf

                        <!-- Baris 1: Nama & Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="name"
                                    class="w-full bg-gray-50 border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                            </div>
                            <div>
                                <label
                                    class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Email</label>
                                <input type="email" name="email"
                                    class="w-full bg-gray-50 border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                            </div>
                        </div>

                        <!-- Baris 2: Password & Custom Dropdown Role -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div x-data="{ showPassword: false }">
                                <label
                                    class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Password
                                    Baru</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        class="w-full bg-gray-50 border border-gray-300 rounded-xl p-4 pr-12 focus:ring-2 focus:ring-[#5c54d8] focus:border-[#5c54d8] transition-colors"
                                        required minlength="8" placeholder="Minimal 8 karakter">

                                    <!-- Tombol Mata -->
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-[#5c54d8] focus:outline-none transition-colors cursor-pointer">

                                        <!-- Ikon Mata Terbuka (Muncul saat password disembunyikan) -->
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>

                                        <!-- Ikon Mata Tercoret (Muncul saat password ditampilkan) -->
                                        <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.528-2.973m2.76-2.027A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.528 2.973m-2.76 2.027l-8-8m8 8l8-8">
                                            </path>
                                        </svg>

                                    </button>
                                </div>
                            </div>

                            <!-- Custom Premium Dropdown Alpine.js -->
                            <div>
                                <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Peran
                                    (Role)</label>
                                <div class="relative" x-data="{ open: false, roles: { 'siswa': 'Siswa', 'guru': 'Guru', 'admin': 'Admin' } }">
                                    <!-- Input hidden untuk dikirim ke backend -->
                                    <input type="hidden" name="role" x-model="role" required>

                                    <!-- Tombol Pemicu Dropdown -->
                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="flex justify-between items-center w-full bg-gray-50 border border-gray-300 text-gray-700 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer">
                                        <span x-text="roles[role]" class="font-bold text-gray-700"></span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <!-- Menu Dropdown -->
                                    <div x-show="open" style="display: none;"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="transform opacity-0 scale-95 translate-y-[-10px]"
                                        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="transform opacity-0 scale-95 translate-y-[-10px]"
                                        class="absolute z-20 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden">

                                        <ul class="py-1">
                                            <!-- Opsi Siswa -->
                                            <li @click="role = 'siswa'; open = false"
                                                class="px-5 py-3 hover:bg-blue-50 cursor-pointer transition-colors flex items-center justify-between"
                                                :class="role === 'siswa' ? 'bg-blue-50 text-blue-700' : 'text-gray-600'">
                                                <span class="font-bold">Siswa</span>
                                                <svg x-show="role === 'siswa'" class="w-5 h-5 text-blue-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </li>
                                            <!-- Opsi Guru -->
                                            <li @click="role = 'guru'; open = false"
                                                class="px-5 py-3 hover:bg-blue-50 cursor-pointer transition-colors flex items-center justify-between"
                                                :class="role === 'guru' ? 'bg-blue-50 text-blue-700' : 'text-gray-600'">
                                                <span class="font-bold">Guru</span>
                                                <svg x-show="role === 'guru'" class="w-5 h-5 text-blue-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </li>
                                            <!-- Opsi Admin -->
                                            <li @click="role = 'admin'; open = false"
                                                class="px-5 py-3 hover:bg-blue-50 cursor-pointer transition-colors flex items-center justify-between"
                                                :class="role === 'admin' ? 'bg-blue-50 text-blue-700' : 'text-gray-600'">
                                                <span class="font-bold">Admin</span>
                                                <svg x-show="role === 'admin'" class="w-5 h-5 text-blue-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 3: Upload Foto Profil (Tambahan Baru) -->
                        <div class="mb-8">
                            <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Foto
                                Profil (Opsional)</label>
                            <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 cursor-pointer">
                            <p class="text-xs text-gray-400 mt-2 font-medium">Format yang didukung: JPG, JPEG, PNG
                                (Maksimal 2MB).</p>
                        </div>

                        <!-- Baris 4: Input Khusus Siswa (Tersembunyi jika role bukan siswa) -->
                        <div x-show="role === 'siswa'" x-transition style="display: none;"
                            class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-6 bg-blue-50/50 rounded-2xl border border-blue-100 relative overflow-hidden">
                            <!-- Dekorasi SVG Background -->
                            <svg class="absolute right-0 bottom-0 text-blue-100 w-32 h-32 transform translate-x-10 translate-y-10"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
                                </path>
                            </svg>

                            <div class="relative z-10">
                                <label
                                    class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Kelas</label>
                                <input type="text" name="kelas"
                                    class="w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                    placeholder="Contoh: X, XI, XII">
                            </div>
                            <div class="relative z-10">
                                <label
                                    class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Jurusan</label>
                                <input type="text" name="jurusan"
                                    class="w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                    placeholder="Contoh: RPL, TKJ, Akuntansi">
                            </div>
                        </div>

                        <!-- Baris 5: Tombol Aksi -->
                        <div class="flex justify-end mt-8 border-t border-gray-100 pt-6">
                            <a href="{{ route('users.index') }}"
                                class="px-6 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl mr-4 hover:bg-gray-50 transition-colors shadow-sm">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5">
                                Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
