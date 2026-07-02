<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">Edit <span class="text-blue-600">Pengguna</span></h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 md:p-10">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" x-data="{ role: '{{ $user->roles->first()->name ?? 'siswa' }}' }">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-500 text-sm font-bold uppercase mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-4 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-500 text-sm font-bold uppercase mb-2">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-4 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-500 text-sm font-bold uppercase mb-2">Password Baru (Opsional)</label>
                                <input type="password" name="password" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-4 focus:ring-blue-500" minlength="8" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div>
                                <label class="block text-gray-500 text-sm font-bold uppercase mb-2">Peran (Role)</label>
                                <select name="role" x-model="role" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-4 focus:ring-blue-500" required>
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div x-show="role === 'siswa'" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-6 bg-blue-50 rounded-2xl border border-blue-100">
                            <div>
                                <label class="block text-gray-500 text-sm font-bold uppercase mb-2">Kelas</label>
                                <input type="text" name="kelas" value="{{ $user->kelas }}" class="w-full bg-white border border-gray-300 rounded-xl p-4 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-500 text-sm font-bold uppercase mb-2">Jurusan</label>
                                <input type="text" name="jurusan" value="{{ $user->jurusan }}" class="w-full bg-white border border-gray-300 rounded-xl p-4 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-end mt-8 border-t border-gray-100 pt-6">
                            <a href="{{ route('users.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl mr-4 hover:bg-gray-200">Batal</a>
                            <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:scale-105">Perbarui Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
